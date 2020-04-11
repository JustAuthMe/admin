<?php


namespace PitouFW\Model;


use PitouFW\Core\Persist;

class AdminUser {
    public static function isLogged() {
        return isset($_SESSION['uid']) && Persist::exists('AdminUser', 'id', $_SESSION['uid']);
    }

    public static function get(): \PitouFW\Entity\AdminUser {
        /** @var \PitouFW\Entity\AdminUser $user */
        $user = Persist::read('AdminUser', $_SESSION['uid']);
        return $user;
    }
}