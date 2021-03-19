<?php

use PitouFW\Entity\CoreCustomer;

?>
<table class="table table-striped" id="subscribers">
    <thead>
        <tr>
            <th>#</th>
            <th>E-mail address</th>
            <th>Language</th>
            <th>Subscribed at</th>
            <th>IP address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($subscribers as $subscriber):
    /** @var CoreCustomer $subscriber */ ?>
        <tr>
            <td><?= $subscriber->getId() ?></td>
            <td><a href="mailto:<?= $subscriber->getEmail() ?>"><?= $subscriber->getEmail() ?></a></td>
            <td><?= $subscriber->getLang() ?></td>
            <td><?= date('Y-m-d H:i:s', $subscriber->getTimestamp()) ?></td>
            <td><?= $subscriber->getIpAddress() ?></td>
            <td>
                <a href="<?= WEBROOT ?>newsletter/subscribers/delete/<?= $subscriber->getId() ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                    <i class="fa fa-trash-alt"></i>
                    Remove
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#subscribers').DataTable({
            order: []
        });
    });
</script>