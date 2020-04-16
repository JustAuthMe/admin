<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Entity\AdminInvitation;
use PitouFW\Model\AdminUser;

switch (Request::get()->getArg(2)) {
    case 'revoke':
        if (Persist::exists('AdminInvitation', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('AdminInvitation', Request::get()->getArg(3));
            Alert::success('Invitation revoked successfully.');
        }

        header('location: ' . WEBROOT . 'admin/invitations');
        die;

    default:
        if (POST) {
            if ($_POST['email'] !== '' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                if (!Persist::exists('AdminUser', 'email', $_POST['email'])) {
                    if (Persist::exists('AdminRole', 'id', $_POST['role'])) {
                        $invitation = new AdminInvitation(
                            0,
                            AdminUser::get()->getId(),
                            $_POST['email'],
                            $_POST['role'],
                            Utils::time()
                        );

                        Persist::create($invitation);
                        Alert::success('Successfully invited!');
                    } else {
                        Alert::error('Unknow role.');
                    }
                } else {
                    Alert::error('An admin with this E-Mail already exists.');
                }
            } else {
                Alert::error('Please provide a valid E-Mail address.');
            }
        }

        Data::get()->add('TITLE', 'Admin panel invitations');
        Data::get()->add('roles', Persist::fetchAll('AdminRole', "ORDER BY id DESC"));
        Data::get()->add('invitations', Persist::fetchAll('AdminInvitation', "ORDER BY id DESC"));
        Controller::renderView('admin/invitations');
}