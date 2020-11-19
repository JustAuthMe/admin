<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class ConsoleApp implements Resourceable {
    private $id;
    private $remote_resource_id;
    private $user_id;
    private $organization_id;
    private $created_at;
    private $updated_at;

    public function __construct($id = 0, $remote_resource_id = 0, $user_id = null, $organization_id = null, $created_at = 0, $updated_at = 0) {
        $this->id = $id;
        $this->setRemoteResourceId($remote_resource_id);
        $this->setUserId($user_id);
        $this->setOrganizationId($organization_id);
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
    }

    public static function getTableName(): string {
        return 'apps';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRemoteResourceId() {
        return $this->remote_resource_id;
    }

    public function setRemoteResourceId($remote_resource_id) {
        $this->remote_resource_id = $remote_resource_id;
        if (Persist::exists('CoreClientApp', 'id', $remote_resource_id)) {
            $this->client_app = Persist::read('CoreClientApp', $remote_resource_id);
        }
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        if ($user_id !== null && Persist::exists('ConsoleUser', 'id', $user_id)) {
            $this->user = Persist::read('ConsoleUser', $user_id);
        }
    }

    public function getOrganizationId() {
        return $this->organization_id;
    }

    public function setOrganizationId($organization_id) {
        $this->organization_id = $organization_id;
        if ($organization_id !== null && Persist::exists('ConsoleOrganization', 'id', $organization_id)) {
            $this->organization = Persist::read('ConsoleOrganization', $organization_id);
        }
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
}
