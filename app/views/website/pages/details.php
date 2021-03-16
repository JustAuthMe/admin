<?php

use PitouFW\Entity\WebsitePage;

/** @var WebsitePage $page */

if ($page->isPublished()):
?>
<a href="<?= WEBROOT ?>website/pages/unpublish/<?= $page->getId() ?>" class="btn btn-outline-warning mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-recycle"></i>
    Unpublish page
</a>
<?php else: ?>
<a href="<?= WEBROOT ?>website/pages/publish/<?= $page->getId() ?>" class="btn btn-outline-success mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-paper-plane"></i>
    Publish page
</a>
<?php endif ?>
<a href="<?= WEBROOT ?>website/pages/delete/<?= $page->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-trash-alt"></i>
    Delete page
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required class="form-control" value="<?= $page->getTitle() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="route">URL:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">https://justauth.me/p/</div>
                </div>
                <input type="text" name="route" id="route" required class="form-control" pattern="[a-z0-9-]+" value="<?= $page->getRoute() ?>" />
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="lang">Lang:</label>
            <input type="text" name="lang" id="lang" placeholder="The page language code: en, fr, es, it, etc." required class="form-control" value="<?= $page->getLang() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="alternate_to">Alternate to:</label>
            <select class="form-control" name="alternate_to" id="alternate_to">
                <option value="">-- Choose one (optional) --</option>
                <?php foreach ($pages as $page2):
                    /** @var WebsitePage $page2 */ ?>
                    <option value="<?= $page2->getId() ?>" <?= $page->getAlternateTo() === $page2->getId() ? 'selected' : '' ?>><?= $page2->getTitle() ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="content">Content:</label>
        <textarea rows="25" name="content" id="content" required class="form-control"><?= $page->getContent() ?></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>
