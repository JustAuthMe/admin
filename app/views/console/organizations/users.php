<?php

use PitouFW\Entity\ConsoleOrganizationUser;
use PitouFW\Entity\ConsoleUser;

?>
<table class="table table-striped" id="users">
    <thead>
    <tr>
        <th>#</th>
        <th>Full name</th>
        <th>E-Mail address</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($organization_users as $organization_user):
        /** @var ConsoleOrganizationUser $organization_user */ ?>
        <tr>
            <td><?= $organization_user->getId() ?></td>
            <td><?= $organization_user->user->getFirstname() . ' ' . $organization_user->user->getLastname() ?></td>
            <td><?= $organization_user->user->getEmail() ?></td>
            <td>
                <?php if ($organization_user->getRole() == 10): ?>
                <span class="badge badge-warning">Admin</span>
                <?php elseif ($organization_user->getRole() == 999): ?>
                <span class="badge badge-danger">Owner</span>
                <?php else: ?>
                <span class="badge badge-primary">Member</span>
                <?php endif ?>
            </td>
            <td>
                <a href="<?= WEBROOT ?>console/users/details/<?= $organization_user->user->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <a href="<?= WEBROOT ?>console/users/apps/<?= $organization_user->user->getId() ?>" class="btn btn-outline-success">
                    <i class="fab fa-app-store"></i>
                    Apps
                </a>
                <a href="<?= WEBROOT ?>console/users/organizations/<?= $organization_user->user->getId() ?>" class="btn btn-outline-info">
                    <i class="fas fa-users"></i>
                    Organizations
                </a>
                <?php if ($organization_user->getRole() != 999): ?>
                <a href="<?= WEBROOT ?>console/organizations/delete_user/<?= $organization_user->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt"></i>
                    Remove from organization
                </a>
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
