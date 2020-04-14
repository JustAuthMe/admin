<form action="" method="post" id="new">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" placeholder="The page title" required class="form-control" value="<?= $_POST['title'] ?? '' ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="route">URL:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">https://justauth.me/p/</div>
                </div>
                <input type="text" name="route" id="route" placeholder="some-nice-slug" required class="form-control" pattern="[a-z0-9-]+" value="<?= $_POST['route'] ?? '' ?>" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="content">Content:</label>
        <textarea rows="25" name="content" id="content" required class="form-control" placeholder="Write your _awesome_ Markdown content here"><?= $_POST['content'] ?? '' ?></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" onmousedown="document.getElementById('new').setAttribute('action', '?publish=1')">
            <i class="fas fa-check-circle"></i>
            Publish
        </button>
        <button type="submit" class="btn btn-primary" onmousedown="document.getElementById('new').setAttribute('action', '')">
            <i class="fas fa-save"></i>
            Save
        </button>
    </div>
</form>

<script type="text/javascript">
    slugify = str => {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to   = "aaaaeeeeiiiioooouuuunc------";
        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        return str.replace(/^-+|-+$/g, ''); // trim -
    };

    let old_value = '';
    const route = document.getElementById('route');
    document.getElementById('title').onkeyup = e => {
        if (route.value === '' || route.value === slugify(old_value)) {
            route.value = slugify(e.target.value);
        }
        old_value = e.target.value;
    };
</script>