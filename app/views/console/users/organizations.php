<?php



?>
<table class="table table-striped" id="user_organizations">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Created at</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php

    use PitouFW\Entity\ConsoleOrganizationUser;

    foreach ($user_organizations as $user_organization):
        /** @var ConsoleOrganizationUser $user_organization */ ?>
        <tr>
            <td><?= $user_organization->organization->getId() ?></td>
            <td><?= $user_organization->organization->getName() ?></td>
            <td><?= $user_organization->organization->getCreatedAt() ?></td>
            <td>
                <?php if ($user_organization->getRole() == 10): ?>
                    <span class="badge badge-warning">Admin</span>
                <?php elseif ($user_organization->getRole() == 999): ?>
                    <span class="badge badge-danger">Owner</span>
                <?php else: ?>
                    <span class="badge badge-primary">Member</span>
                <?php endif ?>
            </td>
            <td>
                <a href="<?= WEBROOT ?>console/organizations/details/<?= $user_organization->organization->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <a href="<?= WEBROOT ?>console/organizations/apps/<?= $user_organization->organization->getId() ?>" class="btn btn-outline-success">
                    <i class="fab fa-app-store"></i>
                    Apps
                </a>
                <a href="<?= WEBROOT ?>console/organizations/users/<?= $user_organization->organization->getId() ?>" class="btn btn-outline-info">
                    <i class="fas fa-users"></i>
                    Users
                </a>
                <?php if ($user_organization->getRole() != 999): ?>
                    <a href="<?= WEBROOT ?>console/organizations/delete_user/<?= $user_organization->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
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
        $('#user_organizations').DataTable({
            order: []
        });
    });
</script>
