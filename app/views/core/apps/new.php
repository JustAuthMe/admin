<form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group cold-md-6">
            <label for="logo">Logo:</label>
            <input type="file" name="logo" id="logo" class="form-control-file" required />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="The app name" value="<?= $posted['name'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="domain">Domain name:</label>
            <input type="text" name="domain" id="domain" class="form-control" required placeholder="website.domain.com" value="<?= $posted['domain'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="redirect_url">Callback URL:</label>
            <input type="url" name="redirect_url" id="redirect_url" class="form-control" required placeholder="https://" value="<?= $posted['redirect_url'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="data">Data:</label>
            <input type="text" name="data" id="data" class="form-control" required placeholder="data1!, data2!, data3, data4" value="<?= $posted['data'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check-circle"></i>
            Create app
        </button>
    </div>
</form>