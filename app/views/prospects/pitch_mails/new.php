<form action="" method="post">
    <div class="form-row">
        <div class="form-group col-lg-3">
            <label for="lang">Lang:</label>
            <input type="text" maxlength="5" name="lang" id="lang" placeholder="fr, en, it..." required class="form-control" value="<?= $posted['lang'] ?? '' ?>" />
        </div>
        <div class="form-group col-lg-3">
            <label for="label">Label:</label>
            <input type="text" name="label" id="label" required class="form-control" placeholder="Prospect, Influencer, Press..." value="<?= $posted['label'] ?? '' ?>" />
        </div>
        <div class="form-group col-lg-6">
            <label for="button_text">Call to action text:</label>
            <input type="text" name="button_text" id="button_text" class="form-control" placeholder="I'm interested" value="<?= $posted['button_text'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required class="form-control" placeholder="Discover our awesome solution" value="<?= $posted['subject'] ?? '' ?>" />
        </div>
        <div class="form-group col-lg-6">
            <label for="button_link">Call to action link:</label>
            <input type="url" name="button_link" id="button_link" class="form-control" placeholder="mailto:partnership@justauth.me (required if text part is filled)" value="<?= $posted['button_link'] ?? '' ?>" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="pitch_content">Content:</label>
            <textarea onkeyup="processMarkdown()" class="form-control" rows="25" name="content" id="pitch_content" required placeholder="Write your _awesome_ markdown here!"><?= $posted['content'] ?? '' ?></textarea>
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