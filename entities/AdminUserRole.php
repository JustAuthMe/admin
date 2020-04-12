<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class AdminUserRole implements Resourceable {
    private $id;
    private $user_id;
    private $role_id;

    public function __construct($id = 0, $user_id = 0, $role_id = 0) {
        $this->id = $id;
        $this->setUserId($user_id);
        $this->setRoleId($role_id);
    }

    public static function getDbInstance(): PDO {
        return DB::getAdmin();
    }

    public static function getTableName(): string {
        return 'user_role';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        if (Persist::exists('AdminUser', 'id', $user_id)) {
            $this->user = Persist::read('AdminUser', $user_id);
        }
    }

    public function getRoleId() {
        return $this->role_id;
    }

    public function setRoleId($role_id) {
        $this->role_id = $role_id;
        if (Persist::exists('AdminRole', 'id', $role_id)) {
            $this->user = Persist::read('AdminRole', $role_id);
        }
    }
}