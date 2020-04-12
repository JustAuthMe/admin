<?php

use PitouFW\Core\Controller;
use PitouFW\Core\Data;

Data::get()->add('TITLE', 'Dashboard');
Controller::renderView('home');