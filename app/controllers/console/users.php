<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\ConsoleUser;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (Persist::exists('ConsoleUser', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleUser $user */
            $user = Persist::read('ConsoleUser', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['firstname'] !== '') {
                    $user->setFirstname($_POST['firstname']);
                    Alert::success('Changes saved successfully.');
                }

                if ($_POST['lastname'] !== '') {
                    $user->setLastname($_POST['lastname']);
                }

                if ($_POST['email'] !== '' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    if ($_POST['email'] === $user->getEmail() || !Persist::exists('ConsoleUser', 'email', $_POST['email'])) {
                        $user->setEmail($_POST['email']);
                    } else {
                        Alert::error('An user with this E-Mail address already exists');
                    }
                } else {
                    Alert::error('Please provide a valid E-Mail address');
                }

                if ($_POST['pass1'] !== '') {
                    if ($_POST['pass1'] === $_POST['pass2']) {
                        $user->setPassword(password_hash($_POST['pass1'], PASSWORD_DEFAULT));
                    } else {
                        Alert::error('Password and password confirmation must be identical');
                    }
                }

                Persist::update($user);
            }

            Data::get()->add('TITLE', 'Details of Console user #' . $user->getId());
            Data::get()->add('user', $user);
            Controller::renderView('console/users/details');
        } else {
            header('location: ' . WEBROOT . 'console/users');
            die;
        }
        break;

    case 'apps':
        if (Persist::exists('ConsoleUser', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleUser $user */
            $user = Persist::read('ConsoleUser', Request::get()->getArg(3));

            $user_apps = Persist::fetchAll('ConsoleApp', "WHERE user_id = ?", [$user->getId()]);
            $apps = [];
            foreach ($user_apps as $k => $user_app) {
                $apps[$k] = clone $user_app->client_app;
                $apps[$k]->owner = $user_app->getOrganizationId() ?
                    Persist::read('ConsoleOrganization', $user_app->getOrganizationId()) :
                    Persist::read('ConsoleUser', $user_app->getUserId());
            }

            Data::get()->add('TITLE', 'Console user #' . $user->getId() . ' apps');
            Data::get()->add('apps', $apps);
            Controller::renderView('core/apps/list');
        } else {
            header('location: ' . WEBROOT . 'console/users');
            die;
        }
        break;

    case 'organizations':
        if (Persist::exists('ConsoleUser', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleUser $user */
            $user = Persist::read('ConsoleUser', Request::get()->getArg(3));
            $user_organizations = Persist::fetchAll('ConsoleOrganizationUser', "WHERE user_id = ?", [$user->getId()]);

            Data::get()->add('TITLE', 'Console user #' . $user->getId() . ' organizations memberships');
            Data::get()->add('user_organizations', $user_organizations);
            Controller::renderView('console/users/organizations');
        } else {
            header('location: ' . WEBROOT . 'console/users');
            die;
        }
        break;

    case 'delete':
        if (Persist::exists('ConsoleUser', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('ConsoleUser', Request::get()->getArg(3));
            Alert::success('Console user deleted successfully.');
        }

        header('location: ' . WEBROOT . 'console/users');
        die;

    default:
        Data::get()->add('TITLE', 'Console users');
        Data::get()->add('users', Persist::fetchAll('ConsoleUser', "ORDER BY id DESC"));
        Controller::renderView('console/users/list');
}
