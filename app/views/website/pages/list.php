<?php

use PitouFW\Entity\WebsitePage;

?>
<a href="<?= WEBROOT ?>website/pages/new" class="btn btn-success mb-2">
    <i class="fas fa-plus"></i>
    New page
</a>
<br /><br />
<table class="table table-striped" id="pages">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Lang</th>
            <th>Route</th>
            <th>Views</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pages as $page):
        /** @var WebsitePage $page */ ?>
        <tr>
            <td><?= $page->getId() ?></td>
            <td><?= $page->getTitle() ?></td>
            <td><?= $page->getLang() ?></td>
            <td><a target="_blank" rel="noopener" href="https://justauth.me/p/<?= $page->getRoute() . (!$page->isPublished() ? '?render_key=' . JAM_WEBSITE_PAGE_RENDERING_KEY : '') ?>">/p/<?= $page->getRoute() ?></a></td>
            <td><?= $page->getViews() ?></td>
            <td><?= date('Y-m-d H:i:s', $page->getCreatedAt()) ?></td>
            <td><?= date('Y-m-d H:i:s', $page->getUpdatedAt()) ?></td>
            <td><span class="badge badge-<?= $page->isPublished() ? 'success' : 'primary' ?>"><?= $page->isPublished() ? 'Published' : 'Draft' ?></span></td>
            <td>
                <a href="<?= WEBROOT ?>website/pages/details/<?= $page->getId() ?>" class="btn btn-outline-primary">
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
        $('#pages').DataTable({
            order: []
        });
    });
</script>
