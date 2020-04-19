<?php if (!is_null($alert)): ?>
<div id="current">
    <h4>Current alert:</h4>
    <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <i class="fa fa-<?= $alert->type === 'info' ? 'info-circle' : 'exclamation-triangle' ?>" style="float:left;font-size:30px;color:<?= $alert->type === 'info' ? '#3498db' : '#ff9900' ?>;line-height:40px"></i>
                    <p style="padding-left:40px;line-height:40px;margin:0;"><?= $alert->text ?></p>
                </div>
            </div>
        </div>
    </div>
    <p class="mt-2">
        Remaining time: <span id="remaining"><?= $ttl ?></span> seconds
    </p>
    <a href="<?= WEBROOT ?>core/alert/delete" class="btn btn-outline-danger" onclick="return confirm('Are you sure ?')">
        <i class="fa fa-trash-alt"></i>
        Delete alert
    </a>
    <br /><br />
</div>
<?php endif ?>
<h4>Send a new alert:</h4>
<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="type">Alert type:</label>
            <select name="type" id="type" required class="form-control">
                <option value="">Choose one</option>
                <option value="info">Information</option>
                <option value="warning">Warning</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="text">Alert text:</label>
            <textarea name="text" id="text" required class="form-control" rows="3" placeholder="Short explanation of what's going on"></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="ttl">Alert duration (in seconds):</label>
            <input type="tel" name="ttl" id="ttl" class="form-control" placeholder="Optional, default to 86400 (1 day)" />
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-paper-plane"></i>
            Send alert
        </button>
    </div>
</form>

<script type="text/javascript">
    const current = document.getElementById('current');
    const remaining = document.getElementById('remaining');

    const interval = setInterval(() => {
        if (remaining.innerHTML == 0) {
            current.style.display = 'none';
            clearInterval(interval);
        }

        remaining.innerHTML--;
    }, 1000)
</script>