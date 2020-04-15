<?php

use PitouFW\Entity\ConsoleUser;

?>
<table class="table table-striped" id="users">
    <thead>
        <tr>
            <th>#</th>
            <th>Full name</th>
            <th>E-Mail address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user):
        /** @var ConsoleUser $user */ ?>
        <tr>
            <td><?= $user->getId() ?></td>
            <td><?= $user->getFullname() ?></td>
            <td><a href="mailto:<?= $user->getEmail() ?>"><?= $user->getEmail() ?></a></td>
            <td>
                <a href="<?= WEBROOT ?>console/users/details/<?= $user->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
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