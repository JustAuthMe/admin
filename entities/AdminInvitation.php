<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class AdminInvitation implements Resourceable {
    private $id;
    private $user_id;
    private $email;
    private $timestamp;

    public function __construct($id = 0, $user_id = 0, $email = '', $timestamp = 0) {
        $this->id = $id;
        $this->setUserId($user_id);
        $this->email = $email;
        $this->timestamp = $timestamp;
    }

    public static function getDbInstance(): PDO {
        return DB::getAdmin();
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

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        if (Persist::exists('AdminUser', 'id', $user_id)) {
            $this->user = Persist::read('AdminUser', $user_id);
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
}