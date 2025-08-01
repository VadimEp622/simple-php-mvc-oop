<section class="container my-5 d-flex justify-content-center">
    <div class="p-4 shadow border rounded">
        <h3 class="mb-4">Create Forum</h3>
        <form method="post">
            <input type="hidden" name="current_form" value="forum-create-form">
            <div class="row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Title" value="<?= $validation['forum-create-form']['title']['value'] ?? '' ?>" name="title" class="form-control">
                    <?php if ($validation['forum-create-form']['title']['error']) : ?>
                        <p class="text-danger"><?= $validation['forum-create-form']['title']['message'] ?></p>
                    <?php endif ?>
                </div>
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
</section>