<?php

use PitouFW\Entity\AdminPitchMail;
use PitouFW\Entity\AdminProspect;
use PitouFW\Entity\AdminUser;use PitouFW\Model\AdminProspect as AdminProspectModel;

/** @var AdminProspect $prospect */

?>
<a href="<?= WEBROOT ?>prospects/manager/delete/<?= $prospect->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
    <i class="fa fa-trash-alt"></i>
    Remove prospect
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= $prospect->getName() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="contact_email">E-Mail address:</label>
            <input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="email@address" value="<?= $prospect->getContactEmail() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="model_id">Model:</label>
            <select name="model_id" id="model_id" class="form-control">
                <option value="">None</option>
                <?php foreach ($pitch_mails as $pitch):
                    /** @var AdminPitchMail $pitch */ ?>
                    <option value="<?= $pitch->getId() ?>" <?= $prospect->getModelid() === $pitch->getId() ? 'selected' : '' ?>><?= $pitch->getLang() . ' - ' . $pitch->getLabel() ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="contact_name">Contact name:</label>
            <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="John Doe" value="<?= $prospect->getContactName() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="url">Website:</label>
            <input type="url" name="url" id="url" class="form-control" placeholder="https://website" <?= $prospect->getUrl() !== '' ? 'required' : '' ?> value="<?= $prospect->getUrl() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="assigned_id">Assigned to:</label>
            <select name="assigned_id" id="assigned_id" class="form-control">
                <?= $prospect->getAssignedId() === null ? '<option value="">-- Select an option --</option>' : '' ?>
                <?php foreach ($admins as $admin):
                    /** @var AdminUser $admin */ ?>
                    <option value="<?= $admin->getId() ?>" <?= $prospect->getAssignedId() === $admin->getId() ? 'selected' : '' ?>><?= $admin->getFirstname() . ' ' . $admin->getLastname() ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control" required>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= $status ?>" <?= $status === $prospect->getStatus() ? 'selected' : '' ?>><?= AdminProspectModel::STATUS_LABEL[$status] ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>
<br /><br />
<h1 class="h3 mb-0 text-gray-800">Pitch e-mail for <?= $prospect->getName() ?></h1>
<form action="<?= WEBROOT ?>prospects/manager/pitch/<?= $prospect->getId() ?>/save" method="post" id="mail_content">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" required name="subject" id="subject" value="<?= $prospect->getMailSubject() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="pitch_content">Content:</label>
            <textarea onkeyup="processMarkdown()" required name="content" id="pitch_content" class="form-control" rows="30"><?= $prospect->getMailContent() ?></textarea>
        </div>
        <div class="form-group col-lg-6">
            <label>Preview:</label>
            <div id="preview" class="preview"><?= $parser->text($prospect->getMailContent()) ?></div>
        </div>
    </div>
    <button type="submit" class="btn btn-success mb-2" onmousedown="mailContent.action='<?= WEBROOT ?>prospects/manager/pitch/<?= $prospect->getId() ?>/save'">
        <i class="fa fa-check-circle"></i>
        Save pitch
    </button>
    <button type="submit" class="btn btn-outline-info mb-2" onmousedown="mailContent.action = '<?= WEBROOT ?>prospects/manager/pitch/<?= $prospect->getId() ?>/test'">
        <i class="fa fa-cogs"></i>
        Test pitch
    </button>
    <button type="submit" <?= $prospect->getStatus() === AdminProspectModel::STATUS_INCOMPLETE ? 'disabled' : '' ?> class="btn btn-outline-primary mb-2" onmousedown="mailContent.action = '<?= WEBROOT ?>prospects/manager/pitch/<?= $prospect->getId() ?>/send'" onclick="return confirm('Are you sure?')">
        <i class="fa fa-paper-plane"></i>
        Send pitch
    </button>
</form>
<script type="text/javascript">
    const mailContent = document.getElementById('mail_content');
</script>