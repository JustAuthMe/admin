<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;

class AdminPitchMail implements Resourceable {
    private $id;
    private $lang;
    private $subject;
    private $content;
    private $button;
    private $updated_at;
    private $updater_id;

    public function __construct($id = 0, $lang = '', $subject = '', $content='', $button = '', $updated_at = null, $updater_id = 0) {
        $this->id = $id;
        $this->lang = $lang;
        $this->subject = $subject;
        $this->content = $content;
        $this->button = $button;
        $this->updated_at = $updated_at;
        $this->setUpdaterId($updater_id);
    }

    public static function getDbInstance(): PDO {
        return DB::getAdmin();
    }

    public static function getTableName(): string {
        return 'pitch_mail';
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

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getButton() {
        return $this->button;
    }

    public function setButton($button) {
        $this->button = $button;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getUpdaterId() {
        return $this->updater_id;
    }

    public function setUpdaterId($updater_id) {
        $this->updater_id = $updater_id;
        if (Persist::exists('AdminUser', 'id', $updater_id)) {
            $this->updater = Persist::read('AdminUser', $updater_id);
        }
    }
}