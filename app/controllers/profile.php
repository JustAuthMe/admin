<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Model\AdminUser;

$user = AdminUser::get();

if (POST) {
    if ($_POST['email'] !== '' && $_POST['firstname'] !== '' && $_POST['lastname'] !== '') {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $user->setEmail($_POST['email']);
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);

            Alert::success('Profile saved successfully !');
            if ($_FILES['avatar']['size'] > 0) {
                $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, AdminUser::ALLOWED_AVATAR_EXTENSIONS)) {
                    $filename = 'upload/avatar_' . $user->getId() . '.' . $ext;
                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], ROOT . 'public/' . $filename)) {
                        $user->setAvatar(WEBROOT . $filename);
                    } else {
                        Alert::error('Unknown error during Profile picture upload');
                    }
                } else {
                    Alert::error('This file extension is not allowed. Allowed extensions are: ' . implode(', ', AdminUser::ALLOWED_AVATAR_EXTENSIONS));
                }
            }

            Persist::update($user);
        } else {
            Alert::error('Please provide a valid E-Mail address.');
        }
    } else {
        Alert::error('All fields must be filled.');
    }
}

Data::get()->add('TITLE', 'My profile');
Data::get()->add('user', $user);
Controller::renderView('profile');