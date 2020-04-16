<?php

use PitouFW\Entity\AdminRole;
use PitouFW\Entity\AdminUser;
use PitouFW\Model\AdminUser as AdminUserModel;

/** @var AdminUser $admin */

?>
<span class="badge badge-<?= $admin->role->getTheme() ?>"><?= $admin->role->getName() ?></span>
<br /><br />
<?php if (AdminUserModel::get()->getId() !== $admin->getId()): ?>
<a href="<?= WEBROOT ?>admin/users/delete/<?= $admin->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-trash-alt"></i>
    Delete admin
</a>
<?php else: ?>
<button disabled class="btn btn-outline-secondary">
    <i class="fas fa-trash-alt"></i>
    Delete admin
</button>
<?php endif ?>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">E-Mail address:</label>
            <input type="email" name="email" required class="form-control" value="<?= $admin->getEmail() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="role">Role:</label>
            <select name="role" id="role" class="form-control" required>
                <?php foreach ($roles as $role):
                /** @var AdminRole $role */ ?>
                <option value="<?= $role->getId() ?>" <?= $admin->getRoleId() === $role->getId() ? 'selected' : '' ?>><?= $role->getName() ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname">Firstname:</label>
            <input type="text" name="firstname" id="firstname" required class="form-control" value="<?= $admin->getFirstname() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="lastname">Lastname:</label>
            <input type="text" name="lastname" id="Lastname" required class="form-control" value="<?= $admin->getLastname() ?>" />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>
