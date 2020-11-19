<?php

use PitouFW\Entity\ConsoleUser;

/** @var ConsoleUser $user */

?>
<a href="<?= WEBROOT ?>console/users/delete/<?= $user->getId() ?>" class="btn btn-outline-danger mb-2" onclick="return confirm('Are you sure?')">
    <i class="fas fa-trash-alt"></i>
    Delete user
</a>
<br /><br />
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="firstname">Firstname:</label>
            <input type="text" name="firstname" id="firstname" class="form-control" required value="<?= $user->getFirstname() ?>" />
        </div>
        <div class="form-group col-md-3">
            <label for="lastname">Lastname:</label>
            <input type="text" name="lastname" id="lastname" class="form-control" required value="<?= $user->getLastname() ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="email">E-Mail address:</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= $user->getEmail() ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="pass1">New password:</label>
            <input type="password" name="pass1" id="pass1" class="form-control" placeholder="Leave blank if no change is needed" />
        </div>
        <div class="form-group col-md-3">
            <label for="pass2">Confirm new password:</label>
            <input type="password" name="pass2" id="pass2" class="form-control" placeholder="Retype password to confirm" />
        </div>
        <div class="form-group col-md-6">
            <label for="jam_id">JAM ID:</label>
            <input readonly id="jam_id" class="form-control" value="<?= $user->getJamId() ?>" />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i>
            Save changes
        </button>
    </div>
</form>
