<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class ConsoleUser implements Resourceable {
    private $id;
    private $email;
    private $fullname;
    private $password;
    private $jam_id;
    private $validation_token;

    public function __construct($id = 0, $email = '', $fullname = '', $password = '', $jam_id = null, $validation_token = null) {
        $this->id = $id;
        $this->email = $email;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->jam_id = $jam_id;
        $this->validation_token = $validation_token;
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getJamId() {
        return $this->jam_id;
    }

    public function setJamId($jam_id) {
        $this->jam_id = $jam_id;
    }

    public function getValidationToken() {
        return $this->validation_token;
    }

    public function setValidationToken($validation_token) {
        $this->validation_token = $validation_token;
    }
}