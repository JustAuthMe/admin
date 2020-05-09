<?php

use PitouFW\Entity\AdminPitchMail;
use PitouFW\Entity\AdminProspect;
use PitouFW\Model\AdminProspect as AdminProspectModel;

?>
<h4>Add a new prospect</h4>
<form action="" method="post">
    <div class="form-inline mb-2">
        <input type="text" name="name" required placeholder="Name" class="form-control mr-2" />
        <select name="model_id" class="form-control mr-2">
            <option value="">Model (optional)</option>
            <?php foreach ($pitch_mails as $pitch):
            /** @var AdminPitchMail $pitch */ ?>
            <option value="<?= $pitch->getId() ?>"><?= $pitch->getLang() . ' - ' . $pitch->getLabel() ?></option>
            <?php endforeach ?>
        </select>
        <input type="url" name="url" placeholder="https://website (optional)" class="form-control mr-2" />
        <input type="email" name="contact_email" placeholder="email@address (optional)" class="form-control mr-2" />
        <input type="text" name="contact_name" placeholder="Contact Name (optional)" class="form-control mr-2" />
        <button type="submit" class="btn btn-success">
            <i class="fa fa-plus"></i>
            Add
        </button>
    </div>
</form>
<br /><br />
<h4>Prospects list</h4>
<table class="table table-striped" id="prospects">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Model</th>
            <th>E-Mail address</th>
            <th>Contact name</th>
            <th>Added by</th>
            <th>Assigned to</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($prospects as $prospect):
    /** @var AdminProspect $prospect */ ?>
        <tr>
            <td><?= $prospect->getId() ?></td>
            <td>
                <?php if ($prospect->getUrl() !== ''): ?>
                <a href="<?= $prospect->getUrl() ?>" target="_blank" rel="noopener"><?= $prospect->getName() ?></a>
                <?php else: ?>
                <?= $prospect->getName() ?>
                <?php endif ?>
            </td>
            <td><?= $prospect->getModelId() !== null ? $prospect->model->getLang() . ' - ' . $prospect->model->getLabel() : 'None' ?></td>
            <td>
                <a href="mailto:<?= $prospect->getContactEmail() ?>">
                    <?= $prospect->getContactEmail() ?>
                </a>
            </td>
            <td><?= $prospect->getContactName() ?></td>
            <td><?= $prospect->creator->getFirstname() . ' ' . $prospect->creator->getLastname() ?></td>
            <td><?= $prospect->getAssignedId() !== null ? $prospect->assigned->getFirstname() . ' ' . $prospect->assigned->getLastname() : '' ?></td>
            <td>
                <span class="badge badge-<?= AdminProspectModel::STATUS_THEME[$prospect->getStatus()] ?>">
                    <?= AdminProspectModel::STATUS_LABEL[$prospect->getStatus()] ?>
                </span>
            </td>
            <td>
                <a href="<?= WEBROOT ?>prospects/manager/details/<?= $prospect->getId() ?>" class="btn btn-outline-primary">
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
        $('#prospects').DataTable({
            order: []
        });
    });
</script>