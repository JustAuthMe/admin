<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Entity\AdminPermission;
use PitouFW\Model\AdminPermission as AdminPermissionModel;
use PitouFW\Model\AdminUser;

switch (Request::get()->getArg(2)) {
    case 'revoke':
        if (Persist::exists('AdminPermission', 'id', Request::get()->getArg(3))) {
            if (Request::get()->getArg(3) != 1) {
                Persist::deleteById('AdminPermission', Request::get()->getArg(3));
                Alert::success('Permission revoked successfully');
            } else {
                Alert::error('You can\'t revoke your own permission to access permissions page.');
            }
        }

        header('location: ' . WEBROOT . 'admin/permissions');
        die;

    default:
        if (POST) {
            if ($_POST['role'] !== '' && $_POST['route'] !== '') {
                if (!AdminPermissionModel::exists($_POST['role'], $_POST['route'])) {
                    $permission = new AdminPermission(
                        0,
                        $_POST['role'],
                        $_POST['route'],
                        AdminUser::get()->getId(),
                        Utils::time()
                    );

                    Persist::create($permission);
                    Alert::success('Permission granted successfully.');
                } else {
                    Alert::error('This permission already exists.');
                }
            } else {
                Alert::error('All fields must be filled.');
            }
        }

        Data::get()->add('TITLE', 'Admin panel permissions');
        Data::get()->add('roles', Persist::fetchAll('AdminRole', "ORDER BY id DESC"));
        Data::get()->add('permissions', Persist::fetchAll('AdminPermission', "ORDER BY id DESC"));
        Controller::renderView('admin/permissions');
}