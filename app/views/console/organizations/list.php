<?php

use PitouFW\Entity\ConsoleOrganization;

/** @var ConsoleOrganization $organizations */

?>
<table class="table table-striped" id="organizations">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Created at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($organizations as $organization):
        /** @var ConsoleOrganization $organization */ ?>
        <tr>
            <td><?= $organization->getId() ?></td>
            <td><?= $organization->getName() ?></td>
            <td><?= $organization->getCreatedAt() ?></td>
            <td>
                <a href="<?= WEBROOT ?>console/organizations/details/<?= $organization->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <a href="<?= WEBROOT ?>console/organizations/apps/<?= $organization->getId() ?>" class="btn btn-outline-success">
                    <i class="fab fa-app-store"></i>
                    Apps
                </a>
                <a href="<?= WEBROOT ?>console/organizations/users/<?= $organization->getId() ?>" class="btn btn-outline-info">
                    <i class="fas fa-users"></i>
                    Users
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#organizations').DataTable({
            order: []
        });
    });
</script>
