<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;
use PitouFW\Entity\CoreClientApp;
use PitouFW\Model\CoreClientApp as CoreClientAppModel;

switch (Request::get()->getArg(2)) {
    case 'details':
        if (Persist::exists('CoreClientApp', 'id', Request::get()->getArg(3))) {
            /** @var CoreClientApp $app */
            $app = Persist::read('CoreClientApp', Request::get()->getArg(3));

            if (POST) {

            }

            Data::get()->add('TITLE', 'Details of ' . $app->getName() . ' client app');
            Data::get()->add('app', $app);
            Controller::renderView('core/apps/details');
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
        break;

    default:
        Data::get()->add('TITLE', 'Client apps');
        Data::get()->add('apps', Persist::fetchAll('CoreClientApp', "ORDER BY id DESC"));
        Controller::renderView('core/apps/list');
}
