<div class="row mb-4">
    <div class="col-md-4">
        <form action="<?= WEBROOT ?>core/users/search" method="post">
            <div class="form-inline">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" required placeholder="E-Mail address" />
                </div>
                <button type="submit" class="btn btn-outline-primary mx-sm-3"><i class="fas fa-search"></i> Search</button>
            </div>
        </form>
    </div>
</div>

<table id="users" class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Account N° (jam_id)</th>
            <th>Hashed E-Mail</th>
            <th>Registered at</th>
            <th>Registration IP</th>
            <th>Status</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user):
        /** @var \PitouFW\Entity\CoreUser $user */ ?>
        <tr>
            <td><?= $user->getId() ?></td>
            <td><?= substr($user->getUsername(), 0, 10) . '...' . substr($user->getUsername(), -10) ?></td>
            <td><?= substr($user->getUniqid(), 0, 10) . '...' . substr($user->getUniqid(), -10) ?></td>
            <td><?= $user->getTimestamp() ?></td>
            <td><?= $user->getIpAddress() ?></td>
            <td><span class="badge badge-<?= $user->isLocked() ? 'danger' : 'primary' ?>"><?= $user->isLocked() ? 'Locked': 'Running' ?></span></td>
            <td><span class="badge badge-<?= $user->isActive() ? 'success' : 'danger' ?>"><?= $user->isActive() ? 'Yes' : 'No' ?></span></td>
            <td>
                <a href="<?= WEBROOT ?>core/users/details/<?= $user->getId() ?>" class="btn btn-outline-primary">
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