<?php

use PitouFW\Entity\AdminPermission;
use PitouFW\Entity\AdminRole;

?>
<h4>Grant a permission</h4>
<form action="" method="post">
    <div class="form-inline mb-2">
        Grant
        <select name="role" required class="form-control ml-2 mr-2">
            <option value="">Role</option>
            <?php foreach ($roles as $role):
            /** @var AdminRole $role */ ?>
            <option value="<?= $role->getId() ?>"><?= $role->getName() ?></option>
            <?php endforeach ?>
        </select>
        access to
        <div class="input-group ml-2 mr-2">
            <div class="input-group-prepend">
                <div class="input-group-text">https://admin.justauth.me/</div>
                <input type="text" class="form-control" pattern="[a-z0-9/_\*]+" required name="route" placeholder="path/to/route" />
            </div>
        </div>
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i>
            Grant access
        </button>
    </div>
</form>
<br /><br />
<h4>Permissions list</h4>
<table class="table table-striped" id="permissions">
    <thead>
        <tr>
            <th>#</th>
            <th>Role</th>
            <th>Route</th>
            <th>Granted by</th>
            <th>Granted at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($permissions as $permission):
    /** @var AdminPermission $permission */ ?>
        <tr>
            <td><?= $permission->getId() ?></td>
            <td>
                <a href="<?= WEBROOT ?>admin/roles/details/<?= $permission->role->getId() ?>">
                    <span class="badge badge-<?= $permission->role->getTheme() ?>"><?= $permission->role->getName() ?></span>
                </a>
            </td>
            <td>https://admin.justauth.me/<?= $permission->getRoute() ?></td>
            <td>
                <a href="<?= WEBROOT ?>admin/users/details/<?= $permission->user->getId() ?>">
                    <?= $permission->user->getFirstname() . ' ' . $permission->user->getLastname() ?>
                </a>
            </td>
            <td><?= date('Y-m-d H:i:s', $permission->getTimestamp()) ?></td>
            <td>
                <?php if ($permission->getId() != 1): ?>
                <a href="<?= WEBROOT ?>admin/permissions/revoke/<?= $permission->getId() ?>" class="btn btn-outline-danger" onclick="confirm('Are you sure?')">
                    <i class="fas fa-trash-alt"></i>
                    Revoke
                </a>
                <?php else: ?>
                <button class="btn btn-outline-secondary" disabled>
                    <i class="fas fa-trash-alt"></i>
                    Revoke
                </button>
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#permissions').DataTable({
            order: []
        });
    });
</script>
