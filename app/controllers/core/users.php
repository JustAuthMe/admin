<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Entity\CoreUniqidUpdate;
use PitouFW\Entity\CoreUser;

switch (Request::get()->getArg(2)) {
    case 'search':
        if (POST && $_POST['email'] !== '' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $hashed_email = Utils::hashInfo($_POST['email']);
            if (Persist::exists('CoreUser', 'uniqid', $hashed_email)) {
                /** @var CoreUser $user */
                $user = Persist::readBy('CoreUser', 'uniqid', $hashed_email);

                Alert::success('Match found!');
                header('location: ' . WEBROOT . 'core/users/details/' . $user->getId() . '?email=' . urlencode($_POST['email']));
                die;
            }
        }

        Alert::error('No match found.');
        header('location: ' . WEBROOT . 'core/users');
        die;

    case 'details':
        if (Persist::exists('CoreUser', 'id', Request::get()->getArg(3))) {
            /** @var CoreUser $user */
            $user = Persist::read('CoreUser', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['active'] !== '' && in_array((int) $_POST['active'], [0, 1])) {
                    $user->setActive($_POST['active']);
                    Alert::success('Changes saved successfully.');
                }

                if ($_POST['email'] !== '') {
                    $old_uniqid = $user->getUniqid();
                    $new_uniqid = Utils::hashInfo($_POST['email']);

                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $old_uniqid !== $new_uniqid) {
                        $user->setUniqid($new_uniqid);
                        $uniqid_update = new CoreUniqidUpdate(
                            0,
                            $user->getId(),
                            $old_uniqid,
                            $new_uniqid,
                            $_SERVER['REMOTE_ADDR'],
                            Utils::time(),
                            0
                        );
                        Persist::create($uniqid_update);
                    } else {
                        Alert::error('Please provide a valid E-Mail, different from the current one.');
                    }
                }

                Persist::update($user);
            }

            Data::get()->add('TITLE', 'Details of Core user #' . $user->getId());
            Data::get()->add('user', $user);
            if (isset($_GET['email']) && Utils::hashInfo($_GET['email']) === $user->getUniqid()) {
                Data::get()->add('email', $_GET['email']);
            }
            Controller::renderView('core/users/details');
        } else {
            header('location: ' . WEBROOT . 'core/users');
            die;
        }
        break;

    case 'lock':
        if (Persist::exists('CoreUser', 'id', Request::get()->getArg(3))) {
            /** @var CoreUser $user */
            $user = Persist::read('CoreUser', Request::get()->getArg(3));
            $user->setPublicKey('');
            Persist::update($user);
            Alert::success('Account locked successfully.');

            header('location: ' . WEBROOT . 'core/users/details/' . $user->getId());
            die;
        }

        header('location: ' . WEBROOT . 'core/users');
        die;

    case 'delete':
        if (Persist::exists('CoreUser', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('CoreUser', Request::get()->getArg(3));
            Alert::success('Core user successfully deleted.');
        }

        header('location: ' . WEBROOT . 'core/users');
        die;

    default:
        Data::get()->add('TITLE', 'Core users');
        Data::get()->add('users', Persist::fetchAll('CoreUser', 'ORDER BY id DESC'));
        Controller::renderView('core/users/list');
}

