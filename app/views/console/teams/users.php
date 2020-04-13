<?php

use PitouFW\Entity\ConsoleTeamUser;

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
    foreach ($team_users as $team_user):
        /** @var ConsoleTeamUser $team_user */ ?>
        <tr>
            <td><?= $team_user->user->getId() ?></td>
            <td><?= $team_user->user->getFullname() ?></td>
            <td><?= $team_user->user->getEmail() ?></td>
            <td>
                <?php if ($team_user->getRole() == 1): ?>
                <span class="badge badge-success">Developer</span>
                <?php elseif ($team_user->getRole() == 10): ?>
                <span class="badge badge-warning">Admin</span>
                <?php elseif ($team_user->getRole() == 100): ?>
                <span class="badge badge-danger">Owner</span>
                <?php else: ?>
                <span class="badge badge-primary">Member</span>
                <?php endif ?>
            </td>
            <td>
                <a href="<?= WEBROOT ?>console/users/details/<?= $team_user->user->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <?php if ($team_user->getRole() != 100): ?>
                <a href="<?= WEBROOT ?>console/teams/delete_user/<?= $team_user->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt"></i>
                    Remove from team
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