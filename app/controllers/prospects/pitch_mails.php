<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\AdminPitchMail;
use PitouFW\Model\AdminUser;

switch (Request::get()->getArg(2)) {
    case 'new':
        if (POST) {
            if ($_POST['lang'] !== '' && $_POST['subject'] !== '' && $_POST['button'] !== '' && $_POST['content'] !== '') {
                $pitch = new AdminPitchMail(
                    0,
                    $_POST['lang'],
                    $_POST['subject'],
                    $_POST['content'],
                    $_POST['button'],
                    null,
                    AdminUser::get()->getId()
                );

                Persist::create($pitch);
                Alert::success('Pitch e-mail created successfully!');
                header('location: ' . WEBROOT . 'prospects/pitch-mails');
                die;
            } else {
                Alert::error('All fields must be filled.');
            }
        }

        Data::get()->add('TITLE', 'New pitch e-mail');
        Data::get()->add('parser', new Parsedown());
        Controller::renderView('prospects/pitch_mails/new');
        break;

    case 'details':
        if (Persist::exists('AdminPitchMail', 'id', Request::get()->getArg(3))) {
            /** @var AdminPitchMail $pitch */
            $pitch = Persist::read('AdminPitchMail', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['subject'] !== '' && $_POST['button'] !== '' && $_POST['content'] !== '' ) {
                    $pitch->setSubject($_POST['subject']);
                    $pitch->setContent($_POST['content']);
                    $pitch->setButton($_POST['button']);
                    $pitch->setUpdatedAt(date('Y-m-d H:i:s'));
                    $pitch->setUpdaterId(AdminUser::get()->getId());

                    Persist::update($pitch);
                    Alert::success('Pitch e-mail updated successfully!');
                } else {
                    Alert::error('Subject and content cannot be left empty');
                }
            }

            Data::get()->add('TITLE', 'Details of ' . strtoupper($pitch->getLang()) . ' pitch e-mail');
            Data::get()->add('pitch', $pitch);
            Data::get()->add('parser', new Parsedown());
            Controller::renderView('prospects/pitch_mails/details');
        } else {
            header('location: ' . WEBROOT . 'prospects/pitch-mails');
            die;
        }
        break;

    case 'delete':
        if (Persist::exists('AdminPitchMail', 'id', Request::get()->getArg(3))) {
            /** @var AdminPitchMail $pitch $pitch */
            $pitch = Persist::read('AdminPitchMail', Request::get()->getArg(3));

            if (Persist::count('AdminProspect', "WHERE lang = ?", [$pitch->getLang()]) === 0) {
                Persist::delete($pitch);
                Alert::success('Pitch e-mail removed successfully!');
            } else {
                Alert::error('This pitch e-mail is associated to one or many prospects.');
            }
        }

        header('location: ' . WEBROOT . 'prospects/pitch-mails');
        die;

    default:
        Data::get()->add('TITLE', 'Pitch e-mails');
        Data::get()->add('pitchs', Persist::fetchAll('AdminPitchMail', "ORDER BY updated_at DESC"));
        Controller::renderView('prospects/pitch_mails/list');
}