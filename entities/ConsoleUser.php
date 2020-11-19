<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class ConsoleUser implements Resourceable {
    private $id;
    private $email;
    private $password;
    private $remember_token;
    private $created_at;
    private $updated_at;
    private $firstname;
    private $lastname;
    private $jam_id;
    private $email_token;
    private $password_token;

    /**
     * ConsoleUser constructor.
     * @param $id
     * @param $email
     * @param $password
     * @param $remember_token
     * @param $created_at
     * @param $updated_at
     * @param $firstname
     * @param $lastname
     * @param $jam_id
     * @param $email_token
     * @param $password_token
     */
    public function __construct($id = 0, $email = '', $password = '', $remember_token = '', $created_at = 0, $updated_at = 0, $firstname = '', $lastname = '', $jam_id = '', $email_token = '', $password_token = '') {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->remember_token = $remember_token;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->jam_id = $jam_id;
        $this->email_token = $email_token;
        $this->password_token = $password_token;
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
    }

    public static function getTableName(): string {
        return 'users';
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

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($remember_token) {
        $this->remember_token = $remember_token;
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

    public function getJamId() {
        return $this->jam_id;
    }

    public function setJamId($jam_id) {
        $this->jam_id = $jam_id;
    }

    public function getEmailToken() {
        return $this->email_token;
    }

    public function setEmailToken($email_token) {
        $this->email_token = $email_token;
    }

    public function getPasswordToken() {
        return $this->password_token;
    }

    public function setPasswordToken($password_token) {
        $this->password_token = $password_token;
    }
}
