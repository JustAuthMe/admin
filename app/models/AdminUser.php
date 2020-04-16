<?php


namespace PitouFW\Model;


use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Request;

class AdminUser {
    public static function isLogged() {
        return isset($_SESSION['uid']) && Persist::exists('AdminUser', 'id', $_SESSION['uid']);
    }

    public static function get(): \PitouFW\Entity\AdminUser {
        /** @var \PitouFW\Entity\AdminUser $user */
        $user = Persist::read('AdminUser', $_SESSION['uid']);
        return $user;
    }

    public static function updateRoles($old_role, $new_role) {
        $req = DB::getAdmin()->prepare("UPDATE user SET role_id = ? WHERE role_id = ?");
        $req->execute([$new_role, $old_role]);
    }

    public static function hasPermission() {
        /*
         * il faut que le role de l'user actuel ai une permission correspondante à la route actuelle ou à un wildcard
         * pour une route inférieure
         */

        $role_id = self::get()->getRoleId();
        $route = implode('/', Request::get()->getArgs());

        if (AdminPermission::exists($role_id, '*') || AdminPermission::exists($role_id, $route) || AdminPermission::exists($role_id, $route . '/*')) {
            return true;
        }

        $args = explode('/', $route);
        unset($args[count($args) - 1]);
        $count = count($args) - 1;
        for ($i = $count; $i >= 0; $i--) {
            if (AdminPermission::exists($role_id, implode('/', $args) . '/*')) {
                return true;
            }

            unset($args[$i]);
        }

        return false;
    }
}