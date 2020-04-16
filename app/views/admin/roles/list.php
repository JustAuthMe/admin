<?php

use PitouFW\Entity\AdminRole;

?>
<h4>Add a new role</h4>
<form action="" method="post">
    <div class="form-inline">
        <input type="text" name="name" id="name" required placeholder="Role name" class="form-control mr-2" />
        <input type="text" name="slug" id="slug" required placeholder="role-slug" class="form-control mr-2" />
        <select name="theme" class="form-control mr-2" required>
            <option value="">Role theme</option>
            <option value="danger">danger</option>
            <option value="warning">warning</option>
            <option value="success">success</option>
            <option value="info">info</option>
            <option value="primary">primary</option>
            <option value="secondary">secondary</option>
        </select>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-plus"></i>
            Add role
        </button>
    </div>
</form>
<br /><br />
<h4>Roles list</h4>
<table class="table table-striped" id="roles">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Theme</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($roles as $role):
    /** @var AdminRole $role */ ?>
        <tr>
            <td><?= $role->getId() ?></td>
            <td><?= $role->getName() ?></td>
            <td><?= $role->getSlug() ?></td>
            <td><span class="badge badge-<?= $role->getTheme() ?>"><?= $role->getTheme() ?></span></td>
            <td>
                <a href="<?= WEBROOT ?>admin/roles/details/<?= $role->getId() ?>" class="btn btn-outline-primary">
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
        $('#roles').DataTable({
            order: []
        });
    });

    let old_value = '';
    const slug = document.getElementById('slug');
    document.getElementById('name').onkeyup = e => {
        if (slug.value === '' || slug.value === slugify(old_value)) {
            slug.value = slugify(e.target.value);
        }
        old_value = e.target.value;
    };
</script>