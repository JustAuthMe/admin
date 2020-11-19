<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class ConsoleOrganizationUser implements Resourceable {
    private $id;
    private $organization_id;
    private $user_id;
    private $role;

    public function __construct($id = 0, $organization_id = 0, $user_id = 0, $role = 0) {
        $this->id = $id;
        $this->setOrganizationId($organization_id);
        $this->setUserId($user_id);
        $this->role = $role;
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
    }

    public static function getTableName(): string {
        return 'organization_user';
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
        if (Persist::exists('ConsoleUser', 'id', $user_id)) {
            $this->user = Persist::read('ConsoleUser', $user_id);
        }
    }

    public function getOrganizationId() {
        return $this->organization_id;
    }

    public function setOrganizationId($organization_id) {
        $this->organization_id = $organization_id;
        if (Persist::exists('ConsoleOrganization', 'id', $organization_id)) {
            $this->organization = Persist::read('ConsoleOrganization', $organization_id);
        }
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }
}
