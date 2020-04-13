<?php

use PitouFW\Entity\ConsoleTeam;

/** @var ConsoleTeam $teams */

?>
<table class="table table-striped" id="teams">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Creator</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($teams as $team):
        /** @var ConsoleTeam $team */ ?>
        <tr>
            <td><?= $team->getId() ?></td>
            <td><?= $team->getName() ?></td>
            <td><a href="<?= WEBROOT ?>console/users/details/<?= $team->user->getid() ?>"><?= $team->user->getFullname() ?></a></td>
            <td>
                <a href="<?= WEBROOT ?>console/teams/details/<?= $team->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <a href="<?= WEBROOT ?>console/teams/apps/<?= $team->getId() ?>" class="btn btn-outline-success">
                    <i class="fab fa-app-store"></i>
                    Apps
                </a>
                <a href="<?= WEBROOT ?>console/teams/users/<?= $team->getId() ?>" class="btn btn-outline-info">
                    <i class="fas fa-users"></i>
                    Members
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#teams').DataTable({
            order: []
        });
    });
</script>
