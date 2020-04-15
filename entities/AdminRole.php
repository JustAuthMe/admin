<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class AdminRole implements Resourceable {
    private $id;
    private $name;
    private $slug;
    private $theme;

    public function __construct($id = 0, $name = '', $slug = '', $theme = '') {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->theme = $theme;
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

    public function getTheme(): string {
        return $this->theme;
    }

    public function setTheme(string $theme) {
        $this->theme = $theme;
    }
}