<?php

use PitouFW\Entity\AdminPitchMail;

/** @var AdminPitchMail $pitch */

?>
<a href="<?= WEBROOT ?>prospects/pitch-mails/delete/<?= $pitch->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fa fa-trash-alt"></i>
    Delete pitch
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6 col-lg-4 col-xl-3">
            <label for="lang">Lang:</label>
            <input type="text" disabled id="lang" class="form-control" value="<?= $pitch->getLang() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required class="form-control" value="<?= $pitch->getSubject() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="button">Call to action text:</label>
            <input type="text" name="button" id="button" required class="form-control" value="<?= $pitch->getButton() ?>" />
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
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>