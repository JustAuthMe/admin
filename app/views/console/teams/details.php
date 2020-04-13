<?php

use PitouFW\Entity\ConsoleTeam;

/** @var ConsoleTeam $team */

?>
<a href="<?= WEBROOT ?>console/teams/delete/<?= $team->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-trash-alt"></i>
    Delete team
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= $team->getName() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="user_id">Creator:</label>
            <input type="text" id="user_id" class="form-control" disabled value="<?= $team->user->getFullname() ?>" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i>
                Save changes
            </button>
        </div>
    </div>
</form>