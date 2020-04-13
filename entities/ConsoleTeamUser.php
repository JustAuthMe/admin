<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class ConsoleTeamUser implements Resourceable {
    private $id;
    private $user_id;
    private $team_id;
    private $role;

    public function __construct($id = 0, $user_id = 0, $team_id = 0, $role = 0) {
        $this->id = $id;
        $this->setUserId($user_id);
        $this->setTeamId($team_id);
        $this->role = $role;
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
    }

    public static function getTableName(): string {
        return 'team_user';
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

    public function setRole($role) {
        $this->role = $role;
    }
}