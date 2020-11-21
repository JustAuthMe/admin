<?php

use PitouFW\Entity\CoreClientApp;

?>
<a href="<?= WEBROOT ?>core/apps/new" class="btn btn-success mb-4">
    <i class="fa fa-plus"></i>
    New client app
</a>
<table class="table table-striped" id="apps">
    <thead>
        <tr>
            <th>#</th>
            <th>Logo</th>
            <th>Name</th>
            <th>URL</th>
            <th>Owner</th>
            <th>Mode</th>
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
            <td><a href="<?= $app->getUrl() ?>" target="_blank" rel="noopener"><?= $app->getUrl() ?></a></td>
            <td><?= !empty($app->owner) && gettype($app->owner) === 'object' ?
                    (get_class($app->owner) === 'PitouFW\Entity\ConsoleOrganization' ?
                        '<a href="' . WEBROOT . 'console/organizations/details/' . $app->owner->getId() . '"><i class="fas fa-building"></i> ' . $app->owner->getName() . '</a>' :
                        '<a href="' . WEBROOT . 'console/users/details/' . $app->owner->getId() . '"><i class="fas fa-user"></i> ' . $app->owner->getFirstname() . ' ' . $app->owner->getLastname() . '</a>'
                    ) : '-' ?></td>
            <td>
                <span class="badge badge-<?= $app->isDev() ? 'warning' : 'success' ?>">
                    <?= $app->isDev() ? 'Development' : 'Production' ?>
                </span>
            </td>
            <td>
                <a href="<?= WEBROOT ?>core/apps/details/<?= $app->getId() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Details
                </a>
                <a href="https://core.justauth.me/auth?app_id=<?= $app->getAppId() ?>&redirect_url=<?= urlencode($app->getRedirectUrl()) ?>" target="_blank" rel="noopener" class="btn btn-outline-success">
                    <i class="fa fa-user-check"></i>
                    Login
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
