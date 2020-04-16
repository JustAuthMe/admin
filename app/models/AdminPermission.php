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
}