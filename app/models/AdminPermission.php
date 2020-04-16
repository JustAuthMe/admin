<?php


namespace PitouFW\Model;


use PitouFW\Core\DB;

class AdminPermission {
    public static function exists($role_id, $route) {
        $req = DB::getAdmin()->prepare("SELECT COUNT(*) AS cnt FROM permission WHERE role_id = ? AND route = ?");
        $req->execute([$role_id, $route]);

        $rep = $req->fetch();
        $req->closeCursor();

        return $rep['cnt'] > 0;
    }

    public static function p($route = null) {
        if (is_array($route)) {
            $return = false;
            foreach ($route as $r) {
                $return = $return || AdminUser::hasPermission($r);
            }

            return $return;
        }

        return AdminUser::hasPermission($route);
    }
}