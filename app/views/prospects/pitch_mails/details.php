<?php

use PitouFW\Entity\AdminPitchMail;

/** @var AdminPitchMail $pitch */

?>
<a href="<?= WEBROOT ?>prospects/pitch-mails/delete/<?= $pitch->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fa fa-trash-alt"></i>
    Delete pitch
</a>
<br /><br />
<form action="" method="post" id="form">
    <div class="form-row">
        <div class="form-group col-lg-3">
            <label for="lang">Lang:</label>
            <input type="text" readonly id="lang" class="form-control" value="<?= $pitch->getLang() ?>" />
        </div>
        <div class="form-group col-lg-3">
            <label for="label">Label:</label>
            <input type="text" name="label" id="label" required class="form-control" value="<?= $pitch->getLabel() ?>" />
        </div>
        <div class="form-group col-lg-6">
            <label for="button_text">Call to action text:</label>
            <input type="text" name="button_text" id="button_text" class="form-control" placeholder="I'm interested (optional)" value="<?= $pitch->getButtonText() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required class="form-control" value="<?= $pitch->getSubject() ?>" />
        </div>
        <div class="form-group col-lg-6">
            <label for="button_link">Call to action link:</label>
            <input type="url" name="button_link" id="button_link" class="form-control" placeholder="mailto:partnership@justauth.me (required if text is filled)" value="<?= $pitch->getButtonLink() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="pitch_content">Content:</label>
            <textarea onkeyup="processMarkdown()" class="form-control" rows="25" name="content" id="pitch_content" required><?= $pitch->getContent() ?></textarea>
        </div>
        <div class="form-group col-lg-6">
            <label>Preview:</label>
            <div id="preview" class="preview"><?= $parser->text($pitch->getContent()) ?></div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" onmousedown="form.action = '<?= WEBROOT ?>prospects/pitch-mails/details/<?= $pitch->getId() ?>'">
            <i class="fa fa-check-circle"></i>
            Save changes
        </button>
        <button type="submit" class="btn btn-outline-info" onmousedown="form.action = '<?= WEBROOT ?>prospects/pitch-mails/details/<?= $pitch->getId() ?>/test'">
            <i class="fa fa-cogs"></i>
            Test pitch
        </button>
    </div>
</form>

<script type="text/javascript">
    const form = document.getElementById('form');
</script>