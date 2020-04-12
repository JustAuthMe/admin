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

    public function __construct($id = 0, $role_id = 0, $route = '') {
        $this->id = $id;
        $this->setRoleId($role_id);
        $this->route = $route;
    }

    public static function getDbInstance(): PDO {
        return DB::getCore();
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
}