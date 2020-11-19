<?php

use PitouFW\Entity\ConsoleOrganization;

/** @var ConsoleOrganization $organization */

?>
<a href="<?= WEBROOT ?>console/organizations/delete/<?= $organization->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-trash-alt"></i>
    Delete organization
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= $organization->getName() ?>" />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>
