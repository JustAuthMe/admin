<?php


namespace PitouFW\Entity;


use PDO;
use PitouFW\Core\DB;
use PitouFW\Core\Persist;
use PitouFW\Core\Resourceable;
use PitouFW\Model\AdminProspect as AdminProspectModel;

class AdminProspect implements Resourceable {
    private $id;
    private $name;
    private $lang;
    private $url;
    private $contact_email;
    private $contact_name;
    private $mail_subject;
    private $mail_content;
    private $creator_id;
    private $assigned_id;
    private $status;
    private $updated_at;

    public function __construct($id = 0, $name = '', $lang = '', $url = '', $contact_email = '', $contact_name = '', $mail_subject = '', $mail_content = '', $creator_id = 0, $assigned_id = null, $status = AdminProspectModel::STATUS_INCOMPLETE, $updated_at = null) {
        $this->id = $id;
        $this->name = $name;
        $this->lang = $lang;
        $this->url = $url;
        $this->contact_email = $contact_email;
        $this->contact_name = $contact_name;
        $this->mail_subject = $mail_subject;
        $this->mail_content = $mail_content;
        $this->setCreatorId($creator_id);
        $this->setAssignedId($assigned_id);
        $this->status = $status;
        $this->updated_at = $updated_at;
    }

    public static function getDbInstance(): PDO {
        return DB::getAdmin();
    }

    public static function getTableName(): string {
        return 'prospect';
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

    public function getLang() {
        return $this->lang;
    }

    public function setLang($lang) {
        $this->lang = $lang;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getContactEmail() {
        return $this->contact_email;
    }

    public function setContactEmail($contact_email) {
        $this->contact_email = $contact_email;
    }

    public function getContactName() {
        return $this->contact_name;
    }

    public function setContactName($contact_name) {
        $this->contact_name = $contact_name;
    }

    public function getMailSubject() {
        return $this->mail_subject;
    }

    public function setMailSubject($mail_subject) {
        $this->mail_subject = $mail_subject;
    }

    public function getMailContent() {
        return $this->mail_content;
    }

    public function setMailContent($mail_content) {
        $this->mail_content = $mail_content;
    }

    public function getCreatorId() {
        return $this->creator_id;
    }

    public function setCreatorId($creator_id) {
        $this->creator_id = $creator_id;
        if (Persist::exists('AdminUser', 'id', $creator_id)) {
            $this->creator = Persist::read('AdminUser', $creator_id);
        }
    }

    public function getAssignedId() {
        return $this->assigned_id;
    }

    public function setAssignedId($assigned_id) {
        $this->assigned_id = $assigned_id;
        if (Persist::exists('AdminUser', 'id', $assigned_id)) {
            $this->assigned = Persist::read('AdminUser', $assigned_id);
        }
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
}