<?php


namespace PitouFW\Model;


use PitouFW\Core\Persist;
use PitouFW\Core\Utils;

class CoreClientApp {
    public static function generateSecret($length = 32) {
        do {
            $secret = Utils::generateToken($length);
        } while (Persist::exists('CoreClientApp', 'secret', $secret));

        return $secret;
    }
}