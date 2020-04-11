<?php
namespace PitouFW\Entity;

use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class AdminUser implements Resourceable {
    private $id;
    private $jam_id;
    private $email;
    private $firstname;
    private $lastname;
    private $avatar;
    private $reg_timestamp;

    public function __construct($id = 0, $jam_id = '', $email = '', $firstname = '', $lastname = '', $avatar = '', $reg_timestamp = 0) {
        $this->id = $id;
        $this->jam_id = $jam_id;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->avatar = $avatar;
        $this->reg_timestamp = $reg_timestamp;
    }

    public static function getDbInstance(): \PDO {
        return DB::getAdmin();
    }

    public static function getTableName(): string {
        return 'user';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getJamId() {
        return $this->jam_id;
    }

    public function setJamId($jam_id) {
        $this->jam_id = $jam_id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function getRegTimestamp() {
        return $this->reg_timestamp;
    }

    public function setRegTimestamp($reg_timestamp) {
        $this->reg_timestamp = $reg_timestamp;
    }
}