<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class ConsoleTeamApp implements Resourceable {
    private $id;
    private $team_id;
    private $app_id;

    public function __construct($id = 0, $team_id = 0, $app_id = 0) {
        $this->id = $id;
        $this->setTeamId($team_id);
        $this->setAppId($app_id);
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
    }

    public static function getTableName(): string {
        return 'team_app';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function getAppId() {
        return $this->app_id;
    }

    public function setAppId($app_id) {
        $this->app_id = $app_id;
        if (Persist::exists('CoreClientApp', 'id', $app_id)) {
            $this->app = Persist::read('CoreClientApp', $app_id);
        }
    }
}