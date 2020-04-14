<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class AdminRole implements Resourceable {
    private $id;
    private $name;
    private $slug;

    public function __construct($id = 0, $title = '', $slug = '') {
        $this->id = $id;
        $this->name = $title;
        $this->slug = $slug;
    }

    public static function getDbInstance(): PDO {
        RETURN DB::getAdmin();
    }

    public static function getTableName(): string {
        return 'role';
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

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }
}