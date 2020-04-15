<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\AdminRole;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (POST) {

        }
        break;

    case 'delete':
        break;

    default:
        if (POST) {
            if ($_POST['name'] !== '' && $_POST['slug'] !== '' && $_POST['theme'] !== '') {
                if (!Persist::exists('AdminRole', 'name', $_POST['name'])) {
                    if (preg_match("#^[a-z0-9-]+$#", $_POST['slug'])) {
                        if (!Persist::exists('AdminRole', 'slug', $_POST['slug'])) {
                            if (in_array($_POST['theme'], ['danger', 'warning', 'success', 'info', 'primary', 'secondary'])) {
                                $role = new AdminRole(
                                    0,
                                    $_POST['name'],
                                    $_POST['slug'],
                                    $_POST['theme']
                                );

                                Persist::create($role);
                                Alert::success('Role created successfully.');
                            } else {
                                Alert::error('Invalid theme.');
                            }
                        } else {
                            Alert::error('A role with this slug already exists.');
                        }
                    } else {
                        Alert::error('Invalid slug.');
                    }
                } else {
                    Alert::error('A role with this name already exists.');
                }
            } else {
                Alert::error('All fiedls must be filled.');
            }
        }

        Data::get()->add('TITLE', 'Admin roles');
        Data::get()->add('roles', Persist::fetchAll('AdminRole', "ORDER BY id DESC"));
        Controller::renderView('admin/roles/list');
}