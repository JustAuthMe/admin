<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class ConsoleInvitation implements Resourceable {
    private $id;
    private $token;
    private $email;
    private $team_id;
    private $role;

    public function __construct($id = 0, $token = '', $email = '', $team_id = 0, $role = 0) {
        $this->id = $id;
        $this->token = $token;
        $this->email = $email;
        $this->setTeamId($team_id);
        $this->role = $role;
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

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTeamId() {
        return $this->team_id;
    }

    public function setTeamId($team_id) {
        $this->team_id = $team_id;
        if (Persist::exists('ConsoleTeam', 'id', $team_id)) {
            $this->team = Persist::read('ConsoleTeam', $team_id);
        }
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role): void {
        $this->role = $role;
    }
}