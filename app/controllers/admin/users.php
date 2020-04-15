<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\AdminUser;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (Persist::exists('AdminUser', 'id', Request::get()->getArg(3))) {
            /** @var AdminUser $admin */
            $admin = Persist::read('AdminUser', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['email'] !== '' && $_POST['firstname'] !== '' && $_POST['lastname'] !== '' && $_POST['role'] !== '') {
                    $admin->setFirstname($_POST['firstname']);
                    $admin->setLastname($_POST['lastname']);
                    Alert::success('Changes saved successfully.');

                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        if ($_POST['email'] === $admin->getEmail() || !Persist::exists('AdminUser', 'email', $_POST['email'])) {
                            $admin->setEmail($_POST['email']);
                        } else {
                            Alert::error('An admin with this E-Mail already exists');
                        }
                    } else{
                        Alert::error('Please provide a valid E-Mail address');
                    }

                    if (Persist::exists('AdminRole', 'id', $_POST['role'])) {
                        $admin->setRoleId($_POST['role']);
                    } else {
                        Alert::error('Unknow role.');
                    }

                    Persist::update($admin);
                } else {
                    Alert::error('All fields must be filled.');
                }
            }

            Data::get()->add('TITLE', 'Details of Admin #' . $admin->getId() . ': ' . $admin->getFirstname() . ' ' . $admin->getLastname());
            Data::get()->add('admin', $admin);
            Data::get()->add('roles', Persist::fetchAll('AdminRole', "ORDER BY id DESC"));
            Controller::renderView('admin/users/details');
        } else {
            header('location: ' . WEBROOT . 'admin/users');
            die;
        }
        break;

    case 'delete':
        if (Persist::exists('AdminUser', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('AdminUser', Request::get()->getArg(3));
            Alert::success('Admin deleted successfully.');
        }

        header('location: ' . WEBROOT . 'admin/users');
        die;

    default:
        Data::get()->add('TITLE', 'Admin list');
        Data::get()->add('users', Persist::fetchAll('AdminUser', "ORDER BY id DESC"));
        Controller::renderView('admin/users/list');
}