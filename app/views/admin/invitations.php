<?php

use PitouFW\Entity\AdminInvitation;
use PitouFW\Entity\AdminRole;

?>
<h4>Invite someone</h4>
<form action="" method="post">
    <div class="form-inline mb-2">
        <input type="email" name="email" required class="form-control mr-2" placeholder="E-Mail address" />
        <select name="role" class="form-control mr-2" required>
            <option value="">Assigned role</option>
            <?php foreach ($roles as $role):
            /** @var AdminRole $role */ ?>
            <option value="<?= $role->getId() ?>"><?= $role->getName() ?></option>
            <?php endforeach ?>
        </select>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i>
            Send invite
        </button>
    </div>
</form>
<br /><br />
<h4>Pending invites</h4>
<table class="table table-striped" id="invitations">
    <thead>
        <tr>
            <th>#</th>
            <th>E-Mail</th>
            <th>Role</th>
            <th>Invited by</th>
            <th>Invited at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($invitations as $invitation):
    /** @var AdminInvitation $invitation */ ?>
        <tr>
            <td><?= $invitation->getId() ?></td>
            <td><a href="mailto:<?= $invitation->getEmail() ?>"><?= $invitation->getEmail() ?></a></td>
            <td><span class="badge badge-<?= $invitation->role->getTheme() ?>"><?= $invitation->role->getName() ?></span></td>
            <td><a href="<?= WEBROOT ?>admin/users/details/<?= $invitation->getUserId() ?>"><?= $invitation->user->getFirstname() . ' ' . $invitation->user->getLastname() ?></a></td>
            <td><?= date('Y-m-d H:i:s', $invitation->getTimestamp()) ?></td>
            <td>
                <a href="<?= WEBROOT ?>admin/invitations/revoke/<?= $invitation->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
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