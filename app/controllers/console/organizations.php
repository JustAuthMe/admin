<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\ConsoleApp;
use PitouFW\Entity\ConsoleOrganization;
use PitouFW\Entity\ConsoleOrganizationApp;
use PitouFW\Entity\ConsoleOrganizationUser;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (Persist::exists('ConsoleOrganization', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleOrganization $organization */
            $organization = Persist::read('ConsoleOrganization', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['name'] !== '') {
                    $organization->setName($_POST['name']);
                    Alert::success('Changes saved successfully.');
                }

                Persist::update($organization);
            }

            Data::get()->add('TITLE', $organization->getName() . ' organization');
            Data::get()->add('organization', $organization);
            Controller::renderView('console/organizations/details');
        } else {
            header('location: ' . WEBROOT . 'console/organizations');
            die;
        }
        break;

    case 'apps':
        if (Persist::exists('ConsoleOrganization', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleOrganization $organization */
            $organization = Persist::read('ConsoleOrganization', Request::get()->getArg(3));

            $organization_apps = Persist::fetchAll('ConsoleApp', "WHERE organization_id = ?", [$organization->getId()]);
            $apps = [];

            foreach ($organization_apps as $k => $organization_app) {
                /** @var ConsoleApp $organization_app */
                $apps[$k] = clone $organization_app->client_app;
                $apps[$k]->owner = $organization_app->getOrganizationId() ?
                    Persist::read('ConsoleOrganization', $organization_app->getOrganizationId()) :
                    Persist::read('ConsoleUser', $organization_app->getUserId());
            }

            Data::get()->add('TITLE', $organization->getName() . ' organization apps');
            Data::get()->add('apps', $apps);
            Controller::renderView('core/apps/list');
        } else {
            header('location: ' . WEBROOT . 'console/organizations');
            die;
        }
        break;

    case 'users':
        if (Persist::exists('ConsoleOrganization', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleOrganization $organization */
            $organization = Persist::read('ConsoleOrganization', Request::get()->getArg(3));
            $organization_users = Persist::fetchAll('ConsoleOrganizationUser', "WHERE organization_id = ?", [$organization->getId()]);

            Data::get()->add('TITLE', $organization->getName() . ' organization members');
            Data::get()->add('organization_users', $organization_users);
            Controller::renderView('console/organizations/users');
        } else {
            header('location: ' . WEBROOT . 'console/organizations');
            die;
        }
        break;

    case 'delete_user':
        if (Persist::exists('ConsoleOrganizationUser', 'id', Request::get()->getArg(3))) {
            /** @var ConsoleOrganizationUser $organization_user */
            $organization_user = Persist::read('ConsoleOrganizationUser', Request::get()->getArg(3));
            $organization_id = $organization_user->getOrganizationId();

            if ($organization_user->getRole() != 999) {
                Persist::delete($organization_user);
                Alert::success('organization member successfully removed.');
            } else {
                Alert::error('You cannot remove the organization owner.');
            }
        }

        header('location: ' . WEBROOT . 'console/organizations' . (isset($organization_id) ? '/users/' . $organization_id : ''));
        die;

    case 'delete':
        if (Persist::exists('ConsoleOrganization', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('ConsoleOrganization', Request::get()->getArg(3));
            Alert::success('organization deleted successfully');
        }

        header('location: ' . WEBROOT . 'console/organizations');
        die;

    default:
        Data::get()->add('TITLE', 'Developers organizations');
        Data::get()->add('organizations', Persist::fetchAll('ConsoleOrganization', "ORDER BY id DESC"));
        Controller::renderView('console/organizations/list');
}
