<?php

use PitouFW\Entity\ConsoleInvitation;

?>
<table class="table table-striped" id="invitations">
    <thead>
        <tr>
            <th>#</th>
            <th>E-Mail address</th>
            <th>organization</th>
            <th>Role</th>
            <th>Created at</th>
            <th>Used</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($invitations as $invitation):
        /** @var ConsoleInvitation $invitation */ ?>
        <tr>
            <td><?= $invitation->getId() ?></td>
            <td><a href="mailto:<?= $invitation->getEmail() ?>"><?= $invitation->getEmail() ?></a></td>
            <td><a href="<?= WEBROOT ?>console/organizations/details/<?= $invitation->organization->getId() ?>"><?= $invitation->organization->getName() ?></a></td>
            <td>
                <?php if ($invitation->getRole() == 10): ?>
                <span class="badge badge-warning">Admin</span>
                <?php elseif ($invitation->getRole() == 999): ?>
                <span class="badge badge-danger">Owner</span>
                <?php else: ?>
                <span class="badge badge-primary">Member</span>
                <?php endif ?>
            </td>
            <td><?= $invitation->getCreatedAt() ?></td>
            <td><?= $invitation->getUsedAt() ?? 'No' ?></td>
            <td>
                <?php if ($invitation->getUsedAt() === null): ?>
                <a href="<?= WEBROOT ?>console/invitations/revoke/<?= $invitation->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt"></i>
                    Revoke
                </a>
                <?php endif ?>
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
