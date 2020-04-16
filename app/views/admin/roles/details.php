<?php

use PitouFW\Entity\AdminRole;

/** @var AdminRole $role */

?>
<form action="<?= WEBROOT ?>admin/roles/delete/<?= $role->getId() ?>" method="post" onsubmit="return confirm('Are you sure?')">
    <div class="form-inline mb-2">
        <select name="new_role" class="form-control mr-2" required>
            <option value="">New role for <?= $role->getName() ?>s</option>
            <?php foreach ($roles as $new_role):
                /** @var AdminRole $new_role */
                if ($role->getId() !== $new_role->getId()): ?>
                    <option value="<?= $new_role->getId() ?>"><?= $new_role->getName() ?></option>
            <?php endif;
            endforeach; ?>
        </select>
        <button type="submit" class="btn btn-outline-danger">
            <i class="fas fa-trash-alt"></i>
            Delete role
        </button>
    </div>
</form>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required class="form-control" value="<?= $role->getName() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="slug">Slug:</label>
            <input type="text" name="slug" id="slug" required class="form-control" value="<?= $role->getSlug() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="theme">Theme:</label>
            <select name="theme" id="theme" class="form-control" required>
                <option value="danger" <?= $role->getTheme() === 'danger' ? 'selected' : '' ?>>danger</option>
                <option value="warning" <?= $role->getTheme() === 'warning' ? 'selected' : '' ?>>warning</option>
                <option value="success" <?= $role->getTheme() === 'success' ? 'selected' : '' ?>>success</option>
                <option value="info" <?= $role->getTheme() === 'info' ? 'selected' : '' ?>>info</option>
                <option value="primary" <?= $role->getTheme() === 'primary' ? 'selected' : '' ?>>primary</option>
                <option value="secondary" <?= $role->getTheme() === 'secondary' ? 'selected' : '' ?>>secondary</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>
