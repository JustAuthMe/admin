<?php

use PitouFW\Entity\AdminUser;
use PitouFW\Model\AdminUser as AdminUserModel;

?>
<table class="table table-striped" id="users">
    <thead>
        <tr>
            <th>#</th>
            <th>Picture</th>
            <th>E-Mail</th>
            <th>Name</th>
            <th>Role</th>
            <th>Registered at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user):
    /** @var AdminUser $user */ ?>
        <tr>
            <td><?= $user->getId() ?></td>
            <td><img src="<?= $user->getAvatar() ?>" style="height:40px;width:40px;border-radius:20px" /></td>
            <td><a href="mailto:<?= $user->getEmail() ?>"><?= $user->getEmail() ?></a></td>
            <td><?= $user->getFirstname() . ' ' . $user->getLastname() ?></td>
            <td><span class="badge badge-<?= $user->role->getTheme() ?>"><?= $user->role->getName() ?></span></td>
            <td><?= Date('Y-m-d H:i:s', $user->getRegTimestamp()) ?></td>
            <td>
                <?php if ($user->getId() > 1 || AdminUserModel::get()->getId() == 1): ?>
                <a href="<?= WEBROOT ?>admin/users/details/<?= $user->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <?php else: ?>
                <button disabled class="btn btn-outline-secondary">
                    <i class="fas fa-edit"></i>
                    Details
                </button>
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#users').DataTable({
            order: []
        });
    });
</script>
