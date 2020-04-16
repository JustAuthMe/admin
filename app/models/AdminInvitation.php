<?php


namespace PitouFW\Model;


use PitouFW\Core\DB;

class AdminInvitation {
    public static function updateRoles($old_role, $new_role) {
        $req = DB::getAdmin()->prepare("UPDATE invitation SET role_id = ? WHERE role_id = ?");
        $req->execute([$new_role, $old_role]);
    }
}