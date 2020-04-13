<?php

use PitouFW\Entity\ConsoleInvitation;

?>
<table class="table table-striped" id="invitations">
    <thead>
        <tr>
            <th>#</th>
            <th>E-Mail address</th>
            <th>Team</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($invitations as $invitation):
        /** @var ConsoleInvitation $invitation */ ?>
        <tr>
            <td><?= $invitation->getId() ?></td>
            <td><?= $invitation->getEmail() ?></td>
            <td><a href="<?= WEBROOT ?>console/teams/details/<?= $invitation->team->getId() ?>"><?= $invitation->team->getName() ?></a></td>
            <td>
                <?php if ($invitation->getRole() == 1): ?>
                <span class="badge badge-success">Developer</span>
                <?php elseif ($invitation->getRole() == 10): ?>
                <span class="badge badge-warning">Admin</span>
                <?php elseif ($invitation->getRole() == 100): ?>
                <span class="badge badge-danger">Owner</span>
                <?php else: ?>
                <span class="badge badge-primary">Member</span>
                <?php endif ?>
            </td>
            <td>
                <a href="<?= WEBROOT ?>console/invitations/revoke/<?= $invitation->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt"></i>
                    Revoke
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#invitations').DataTable({
            order: []
        });
    });
</script>