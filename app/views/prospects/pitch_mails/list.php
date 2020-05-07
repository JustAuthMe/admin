<?php

use PitouFW\Entity\AdminPitchMail;

?>
<a href="<?= WEBROOT ?>prospects/pitch-mails/new" class="btn btn-success">
    <i class="fa fa-plus"></i>
    New pitch e-mail
</a>
<br /><br />
<table class="table table-striped" id="pitchs">
    <thead>
        <tr>
            <th>#</th>
            <th>Lang</th>
            <th>Subject</th>
            <th>Updated at</th>
            <th>Updated by</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pitchs as $pitch):
    /** @var AdminPitchMail $pitch */ ?>
        <tr>
            <td><?= $pitch->getId() ?></td>
            <td><?= $pitch->getLang() ?></td>
            <td><?= $pitch->getSubject() ?></td>
            <td><?= $pitch->getUpdatedAt() ?></td>
            <td><?= $pitch->updater->getFirstname() . ' ' . $pitch->updater->getLastname() ?></td>
            <td>
                <a href="<?= WEBROOT ?>prospects/pitch-mails/details/<?= $pitch->getId() ?>" class="btn btn-outline-primary">
                    <i class="fa fa-edit"></i>
                    Details
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#pitchs').DataTable({
            order: []
        });
    });
</script>