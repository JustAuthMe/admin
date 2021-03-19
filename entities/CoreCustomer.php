<?php

namespace PitouFW\Entity;

use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class CoreCustomer implements Resourceable {
    private $id;
    private $email;
    private $lang;
    private $timestamp;
    private $ip_address;

    public function __construct($id = 0, $email = '', $lang = 'en', $timestamp = 0, $ip_address = '') {
        $this->id = $id;
        $this->email = $email;
        $this->lang = $lang;
        $this->timestamp = $timestamp;
        $this->ip_address = $ip_address;
    }

    public static function getTableName(): string {
        return 'customer';
    }

    public static function getDbInstance(): PDO {
        return DB::getCore();
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

    public function getLang() {
        return $this->lang;
    }

    public function setLang($lang) {
        $this->lang = $lang;
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
}