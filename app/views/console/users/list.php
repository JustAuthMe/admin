<?php

use PitouFW\Entity\ConsoleUser;

?>
<table class="table table-striped" id="users">
    <thead>
        <tr>
            <th>#</th>
            <th>Full name</th>
            <th>E-Mail address</th>
            <th>Registered at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user):
        /** @var ConsoleUser $user */ ?>
        <tr>
            <td><?= $user->getId() ?></td>
            <td><?= $user->getFirstname() . ' ' . $user->getLastname() ?></td>
            <td><a href="mailto:<?= $user->getEmail() ?>"><?= $user->getEmail() ?></a></td>
            <td><?= $user->getCreatedAt() ?></td>
            <td>
                <a href="<?= WEBROOT ?>console/users/details/<?= $user->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <a href="<?= WEBROOT ?>console/users/apps/<?= $user->getId() ?>" class="btn btn-outline-success">
                    <i class="fab fa-app-store"></i>
                    Apps
                </a>
                <a href="<?= WEBROOT ?>console/users/organizations/<?= $user->getId() ?>" class="btn btn-outline-info">
                    <i class="fas fa-users"></i>
                    Organizations
                </a>
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
