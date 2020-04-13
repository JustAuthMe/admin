<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\ConsoleTeam;
use PitouFW\Entity\CoreClientApp;
use PitouFW\Model\CoreClientApp as CoreClientAppModel;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (Persist::exists('CoreClientApp', 'id', Request::get()->getArg(3))) {
            /** @var CoreClientApp $app */
            $app = Persist::read('CoreClientApp', Request::get()->getArg(3));

            if (POST) {
                if ($_POST['name'] !== '' && $_POST['domain'] !== '' && $_POST['redirect_url'] !== '') {
                    $app->setName($_POST['name']);
                    $app->setDomain($_POST['domain']);
                    $app->setRedirectUrl($_POST['redirect_url']);
                    Persist::update($app);
                    Alert::success('Changes saved successfully.');
                } else {
                    Alert::error('All fields must be filled.');
                }
            }

            Data::get()->add('TITLE', 'Details of ' . $app->getName() . ' app');
            Data::get()->add('app', $app);
            Controller::renderView('core/apps/details');
        } else {
            header('location: ' . WEBROOT . 'core/apps');
            die;
        }
        break;

    case 'secret':
        if (Persist::exists('CoreClientApp', 'id', Request::get()->getArg(3))) {
            /** @var CoreClientApp $app */
            $app = Persist::read('CoreClientApp', Request::get()->getArg(3));

            $new_secret = CoreClientAppModel::generateSecret();
            $app->setSecret($new_secret);
            Persist::update($app);
            Alert::success('Secret successfully reset.');

            header('location: ' . WEBROOT . 'core/apps/details/' . $app->getId());
            die;
        }

        header('location: ' . WEBROOT . 'core/apps');
        die;

    case 'delete':
        if (Persist::exists('CoreClientApp', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('CoreClientApp', Request::get()->getArg(3));
            Alert::success('Client app deleted successfully.');
        }

        header('location: ' . WEBROOT . 'core/apps');
        die;

    default:
        Data::get()->add('TITLE', 'Client apps');
        Data::get()->add('apps', Persist::fetchAll('CoreClientApp', "ORDER BY id DESC"));
        Controller::renderView('core/apps/list');
}
