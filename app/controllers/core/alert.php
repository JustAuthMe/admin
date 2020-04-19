<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;

$redis = new \PitouFW\Core\Redis();
$cache_key = 'app_alert';

switch (Request::get()->getArgs(2)) {
    case 'delete':
        $redis->del($cache_key);
        Alert::success('Alert removed successfully.');
        header('location: ' . WEBROOT . 'core/alert');
        die;

    default:
        if (POST) {
            if ($_POST['type'] !== '' && $_POST['text'] !== '') {
                if (in_array($_POST['type'], ['info', 'warning'])) {
                    $ttl = $_POST['ttl'] !== '' ? (int) $_POST['ttl'] : 86400;
                    $redis->set(
                        $cache_key,
                        [
                            'id' => Utils::time(),
                            'type' => $_POST['type'],
                            'text' => $_POST['text']
                        ],
                        $ttl
                    );
                    Alert::success('Alert successfully sent to all users!');
                } else {
                    Alert::error('Invalid alert type');
                }
            } else {
                Alert::error('ALl fields must be filled.');
            }
        }

        $cached = $redis->get($cache_key);

        Data::get()->add('TITLE', 'In-App alert banner');
        Data::get()->add('alert', $cached !== false ? $cached : null);
        Data::get()->add('ttl', $redis->ttl($cache_key));
        Controller::renderView('core/alert');
}