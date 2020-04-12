<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class CoreUser implements Resourceable {
    private $id;
    private $username;
    private $uniqid;
    private $timestamp;
    private $ip_address;
    private $public_key;
    private $active;

    public function __construct($id = 0, $username = '', $uniqid = '', $timestamp = 0, $ip_address = '', $public_key = '', $active = 0) {
        $this->id = $id;
        $this->username = $username;
        $this->uniqid = $uniqid;
        $this->timestamp = $timestamp;
        $this->ip_address = $ip_address;
        $this->public_key = $public_key;
        $this->active = $active;
    }

    public static function getDbInstance(): PDO {
        return DB::getCore();
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

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUniqid() {
        return $this->uniqid;
    }

    public function setUniqid($uniqid) {
        $this->uniqid = $uniqid;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function getIpAddress() {
        return $this->ip_address;
    }

    public function setIpAddress($ip_address) {
        $this->ip_address = $ip_address;
    }

    public function getPublicKey() {
        return $this->public_key;
    }

    public function setPublicKey($public_key) {
        $this->public_key = $public_key;
    }

    public function getActive() {
        return $this->active;
    }

    public function isActive() {
        return !!$this->getActive();
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function isLocked() {
        return $this->getPublicKey() === '';
    }
}