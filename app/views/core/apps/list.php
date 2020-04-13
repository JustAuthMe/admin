<?php

use PitouFW\Entity\CoreClientApp;

?>
<table class="table table-striped" id="apps">
    <thead>
        <tr>
            <th>#</th>
            <th>Logo</th>
            <th>Name</th>
            <th>Domain name</th>
            <th>Identifier (app_id)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($apps as $app):
        /** @var CoreClientApp $app */ ?>
        <tr>
            <td><?= $app->getId() ?></td>
            <td><img src="<?= $app->getLogo() ?>" style="height:40px;width:40px;border-radius:20px" /></td>
            <td><?= $app->getName() ?></td>
            <td><?= $app->getDomain() ?></td>
            <td><?= $app->getAppId() ?></td>
            <td>
                <a href="<?= WEBROOT ?>core/apps/details/<?= $app->getId() ?>" class="btn btn-outline-primary">
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
        $('#apps').DataTable({
            order: []
        });
    });
</script>