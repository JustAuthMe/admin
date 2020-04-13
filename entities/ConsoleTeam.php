<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class ConsoleTeam implements Resourceable {
    private $id;
    private $name;
    private $user_id;

    public function __construct($id = 0, $name = '', $user_id = 0) {
        $this->id = $id;
        $this->name = $name;
        $this->setUserId($user_id);
    }

    public static function getDbInstance(): PDO {
        return DB::getConsole();
    }

    public static function getTableName(): string {
        return 'team';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
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
}