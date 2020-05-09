<?php

use PitouFW\Entity\CoreUser;

/** @var CoreUser $user */

?>

<?php if ($user->isLocked()): ?>
    <button class="btn btn-outline-secondary mb-2" disabled><i class="fas fa-lock"></i> Locked</button>
<?php else: ?>
    <a href="<?= WEBROOT ?>core/users/lock/<?= $user->getId() ?>" class="btn btn-outline-warning mb-2" onclick="return confirm('Are you sure?')">
        <i class="fas fa-lock"></i>
        Lock account
    </a>
<?php endif ?>
<a href="<?= WEBROOT ?>core/users/delete/<?= $user->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-trash-alt"></i>
    Delete account
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email"><?= !isset($email) ? 'New ' : '' ?>E-Mail address:</label>
            <input type="email" name="email" placeholder="Leave blank if no change is needed" id="email" class="form-control" <?= isset($email) ? 'value="' . htmlentities($email) . '"' : '' ?> />
        </div>
        <div class="form-group col-md-6">
            <label for="username">Account N° (jam_id):</label>
            <input class="form-control" type="text" readonly value="<?= $user->getUsername() ?>" id="username" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="active">Active account:</label>
            <select class="form-control" name="active" id="active">
                <option value="1" <?= $user->isActive() ? 'selected' : ''?>>Yes</option>
                <option value="0" <?= !$user->isActive() ? 'selected' : ''?>>No</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="uniqid">Hashed E-Mail:</label>
            <textarea rows="2" class="form-control" disabled id="uniqid"><?= $user->getUniqid() ?></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <div class="form-group">
                <label form="ip_address">Registration IP:</label>
                <input class="form-control" type="text" readonly value="<?= $user->getIpAddress() ?>" id="ip_address" />
            </div>
            <div class="form-group">
                <label for="timestamp">Registered at:</label>
                <input class="form-control" type="text" readonly value="<?= $user->getTimestamp() ?>" id="timestamp" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Save changes</button>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="pubkey">Public key:</label>
            <textarea rows="10" class="form-control" disabled id="pubkey"><?= $user->getPublicKey() ?></textarea>
        </div>
    </div>
</form>
