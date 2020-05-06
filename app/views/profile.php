<?php

use PitouFW\Entity\AdminUser;

/** @var AdminUser $user */

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
        <div class="col-12 text-center">
            <label for="avatar" class="d-inline-block position-relative">
                <img id="avatar_preview" src="<?= $user->getAvatar() ?>" height="150" class="rounded-circle" />
                <div class="edit-icon">
                    <i class="fa fa-pencil-alt"></i>
                </div>
            </label>
            <input type="file" name="avatar" id="avatar" class="d-none" onchange="onUpdateAvatar(event)" />
        </div>
    </div>
    <br /><br />
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">E-Mail Address:</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= $user->getEmail() ?>" required />
        </div>
        <div class="form-group col-md-6">
            <label for="role">Role:</label>
            <input type="text" disabled id="role" value="<?= $user->role->getName() ?>" class="form-control" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname">Firstname:</label>
            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= $user->getFirstname() ?>" required />
        </div>
        <div class="form-group col-md-6">
            <label for="lastname">Lastname:</label>
            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= $user->getLastname() ?>" />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check-circle"></i>
            Update profile
        </button>
    </div>
</form>

<script type="text/javascript">
    const avatarPreview = document.getElementById('avatar_preview');
    const onUpdateAvatar = e => {
        const fileReader = new FileReader();
        fileReader.onload = () => {
            avatarPreview.src = fileReader.result;
        };
        fileReader.readAsDataURL(e.target.files[0]);
    };
</script>
