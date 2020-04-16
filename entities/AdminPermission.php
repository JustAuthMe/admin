<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class AdminPermission implements Resourceable {
    private $id;
    private $role_id;
    private $route;
    private $user_id;
    private $timestamp;

    public function __construct($id = 0, $role_id = 0, $route = '', $user_id = 0, $timestamp = 0) {
        $this->id = $id;
        $this->setRoleId($role_id);
        $this->route = $route;
        $this->setUserId($user_id);
        $this->timestamp = $timestamp;
    }

    public static function getDbInstance(): PDO {
        return DB::getAdmin();
    }

    public static function getTableName(): string {
        return 'permission';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRoleId() {
        return $this->role_id;
    }

    public function setRoleId($role_id) {
        $this->role_id = $role_id;
        if (Persist::exists('AdminRole', 'id', $role_id)) {
            $this->role = Persist::read('AdminRole', $role_id);
        }
    }

    public function getRoute() {
        return $this->route;
    }

    public function setRoute($route) {
        $this->route = $route;
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

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
}