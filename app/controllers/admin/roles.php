<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\AdminRole;
use PitouFW\Model\AdminInvitation;
use PitouFW\Model\AdminUser;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (Persist::exists('AdminRole', 'id', Request::get()->getArg(3))) {
            /** @var AdminRole $role */
            $role = Persist::read('AdminRole', Request::get()->getArg(3));

            if (POST) {
                Alert::success('Changes saved successfully.');

                if ($_POST['name'] !== '') {
                    if ($role->getName() === $_POST['name'] || !Persist::exists('AdminRole', 'name', $_POST['name'])) {
                        $role->setName($_POST['name']);
                    } else {
                        Alert::error('A role with this name already exists.');
                    }
                }

                if ($_POST['slug'] !== '') {
                    if ($role->getSlug() === $_POST['slug'] || !Persist::exists('AdminRole', 'slug', $_POST['slug'])) {
                        $role->setSlug($_POST['slug']);
                    } else {
                        Alert::error('A role with this slug already exists.');
                    }
                }

                if ($_POST['theme'] !== '' && in_array($_POST['theme'], ['danger', 'warning', 'success', 'info', 'primary', 'secondary'])) {
                    $role->setTheme($_POST['theme']);
                } else {
                    Alert::error('Invalid theme.');
                }

                Persist::update($role);
            }

            Data::get()->add('TITLE', 'Details of role #' . $role->getId() . ': ' . $role->getName());
            Data::get()->add('roles', Persist::fetchAll('AdminRole', "ORDER BY id DESC"));
            Data::get()->add('role', $role);
            Controller::renderView('admin/roles/details');
        } else {
            header('location: ' . WEBROOT . 'admin/roles');
            die;
        }
        break;

    case 'delete':
        if (Persist::exists('AdminRole', 'id', Request::get()->getArg(3))) {
            /** @var AdminRole $role */
            $role = Persist::read('AdminRole', Request::get()->getArg(3));

            if (POST && $role->getId() !== $_POST['new_role'] && Persist::exists('AdminRole', 'id', $_POST['new_role'])) {
                AdminUser::updateRoles($role->getId(), $_POST['new_role']);
                AdminInvitation::updateRoles($role->getId(), $_POST['new_role']);
                Persist::delete($role);
                Alert::success('Role deleted successfully');
            } else {
                Alert::error('Invalid new role');
                header('location: ' . WEBROOT . 'admin/roles/details/' . $role->getId());
                die;
            }
        }

        header('location: ' . WEBROOT . 'admin/roles');
        die;

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