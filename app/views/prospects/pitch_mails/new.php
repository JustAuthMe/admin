<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-xl-3 col-lg-4 col-md-6">
            <label for="lang">Lang:</label>
            <input type="text" maxlength="5" name="lang" id="lang" placeholder="fr, en, it..." required class="form-control" value="<?= $_POST['lang'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required class="form-control" placeholder="Discover our awesome solution" value="<?= $_POST['subject'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="button">Call to action text:</label>
            <input type="text" name="button" id="button" required class="form-control" placeholder="I'm interested" value="<?= $_POST['button'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="pitch_content">Content:</label>
            <textarea onkeyup="processMarkdown()" class="form-control" rows="25" name="content" id="pitch_content" required placeholder="Write your _awesome_ markdown here!"><?= $_POST['content'] ?? '' ?></textarea>
        </div>
        <div class="form-group col-lg-6">
            <label>Preview:</label>
            <div class="preview" id="preview"></div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check-circle"></i>
            Save pitch
        </button>
    </div>
</form>