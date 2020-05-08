<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;

switch (Request::get()->getArg(2)) {
    case 'delete':
        if (Persist::exists('CoreCustomer', 'id', Request::get()->getArg(3))) {
            Persist::deleteById('CoreCustomer', Request::get()->getArg(3));
            Alert::success('Subscriber removed successfully!');
        }

        header('location: '. WEBROOT . 'newsletter/subscribers');
        die;

    default:
        Data::get()->add('TITLE', 'Newsletter subscribers');
        Data::get()->add('subscribers', Persist::fetchAll('CoreCustomer', "ORDER BY id DESC"));
        Controller::renderView('newsletter/subscribers');
}