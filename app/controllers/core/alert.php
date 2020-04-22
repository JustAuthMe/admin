<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;

switch (Request::get()->getArg(2)) {
    case 'delete':
        $opts = ['http' => [
            'method' => 'DELETE',
            'header' => 'X-Access-Token: ' . JAM_INTERNAL_API_KEY . "\r\n",
            'ignore_errors' => true
        ]];
        $context = stream_context_create($opts);
        $response = json_decode(file_get_contents(JAM_ALERT_API, false, $context));

        if ($response->status === 'success') {
            Alert::success('Alert removed successfully.');
        } else {
            Alert::error('Error during alert removal.');
        }
        header('location: ' . WEBROOT . 'core/alert');
        die;

    default:
        if (POST) {
            if ($_POST['type'] !== '' && $_POST['text'] !== '') {
                if (in_array($_POST['type'], ['info', 'warning'])) {
                    $ttl = $_POST['ttl'] !== '' ? (int) $_POST['ttl'] : 86400;

                    $postdata = http_build_query([
                        'alert_type' => $_POST['type'],
                        'alert_text' => $_POST['text'],
                        'alert_ttl' => $_POST['ttl']
                    ]);
                    $opts = ['http' => [
                        'method' => 'POST',
                        'header' => 'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
                            'X-Access-Token: ' . JAM_INTERNAL_API_KEY . "\r\n",
                        'content' => $postdata,
                        'ignore_errors' => true
                    ]];
                    $context = stream_context_create($opts);
                    $response = json_decode(file_get_contents(JAM_ALERT_API, false, $context));

                    if ($response->status === 'success') {
                        Alert::success('Alert successfully sent to all users!');
                    } else {
                        Alert::error('Error during alert sending');
                    }
                } else {
                    Alert::error('Invalid alert type');
                }
            } else {
                Alert::error('ALl fields must be filled.');
            }
        }

        $opts = ['http' => [
            'header' => 'X-Access-Token: ' . JAM_INTERNAL_API_KEY . "\r\n",
            'ignore_errors' => true
        ]];
        $context = stream_context_create($opts);
        $response = json_decode(file_get_contents(JAM_ALERT_API, false, $context));

        Data::get()->add('TITLE', 'In-App alert banner');
        Data::get()->add('alert', $response->status === 'success' ? $response->alert : null);
        Controller::renderView('core/alert');
}