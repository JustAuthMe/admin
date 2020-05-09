<?php

use PitouFW\Entity\CoreClientApp;

/** @var CoreClientApp $app */

?>
<a href="<?= WEBROOT ?>core/apps/secret/<?= $app->getId() ?>" class="btn btn-outline-warning mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-recycle"></i>
    Reset secret
</a>
<a href="<?= WEBROOT ?>core/apps/delete/<?= $app->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-trash-alt"></i>
    Delete app
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" required value="<?= $app->getName() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="app_id">Identifier (app_id):</label>
            <input type="text" class="form-control" readonly id="app_id" value="<?= $app->getAppId() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="domain">Domain name:</label>
            <input type="text" class="form-control" name="domain" id="domain" required value="<?= $app->getDomain() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="secret">Secret:</label>
            <input type="text" class="form-control" readonly id="secret" value="<?= $app->getSecret() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="redirect_url">Redirect URL:</label>
            <input type="url" class="form-control" name="redirect_url" id="redirect_url" required value="<?= $app->getRedirectUrl() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="data">Data:</label>
            <input type="text" class="form-control" name="data" id="data" value="<?= implode(', ', json_decode(html_entity_decode($app->getData()))) ?>" />
        </div>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" <?= $app->isDev() ? 'checked' : '' ?> class="form-check-input" name="dev" id="dev" value="1" />
        <label for="dev" class="form-check-label">Dev mode</label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>
