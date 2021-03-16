<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Resourceable;

class WebsitePage implements Resourceable {
    private $id;
    private $lang;
    private $alternate_to;
    private $title;
    private $route;
    private $content;
    private $views;
    private $created_at;
    private $updated_at;
    private $published;

    /**
     * Page constructor.
     * @param int $id
     * @param string $lang
     * @param int|null $alternate_to
     * @param string $title
     * @param string $route
     * @param string $content
     * @param int $views
     * @param int $created_at
     * @param int $updated_at
     * @param int $published
     */
    public function __construct($id = 0, $lang = '', $alternate_to = null, $title = '', $route = '', $content = '', $views = 0, $created_at = 0, $updated_at = 0, $published = 0) {
        $this->id = $id;
        $this->lang = $lang;
        $this->alternate_to = $alternate_to;
        $this->title = $title;
        $this->route = $route;
        $this->content = $content;
        $this->views = $views;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->published = $published;
    }

    public static function getDbInstance(): PDO {
        return DB::getWebsite();
    }

    public static function getTableName(): string {
        return 'page';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLang() {
        return $this->lang;
    }

    public function setLang($lang) {
        $this->lang = $lang;
    }

    public function getAlternateTo() {
        return $this->alternate_to;
    }

    public function setAlternateTo($alternate_to) {
        $this->alternate_to = $alternate_to;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getRoute() {
        return $this->route;
    }

    public function setRoute($route) {
        $this->route = $route;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getViews() {
        return $this->views;
    }

    public function setViews($views) {
        $this->views = $views;
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

    public function getPublished() {
        return $this->published;
    }

    public function isPublished(): bool {
        return !!$this->getPublished();
    }

    public function setPublished($published) {
        $this->published = $published;
    }
}
