<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class ConsoleInvitation implements Resourceable {
    private $id;
    private $email;
    private $organization_id;
    private $role;
    private $used_at;
    private $created_at;
    private $updated_at;
    private $token;

    public function __construct($id = 0, $email = '', $organization_id = 0, $role = 0, $used_at = 0, $created_at = 0, $updated_at = 0, $token = '') {
        $this->id = $id;
        $this->email = $email;
        $this->setOrganizationId($organization_id);
        $this->role = $role;
        $this->used_at = $used_at;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->token = $token;
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
    }

    public static function getTableName(): string {
        return 'invitation';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
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

    public function getUsedAt() {
        return $this->used_at;
    }

    public function setUsedAt($used_at) {
        $this->used_at = $used_at;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }
}
