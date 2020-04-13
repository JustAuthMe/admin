<?php

use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;

if (Request::get()->getArg(2) === 'revoke' && Persist::exists('ConsoleInvitation', 'id', Request::get()->getArg(3))) {
    Persist::deleteById('ConsoleInvitation', Request::get()->getArg(3));
    \PitouFW\Core\Alert::success('Invitation revoked successfully.');
}

Data::get()->add('TITLE', 'Console invitations');
Data::get()->add('invitations', Persist::fetchAll('ConsoleInvitation', "ORDER BY id DESC"));
Controller::renderView('console/invitations');