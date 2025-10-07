<section class="container my-5 d-flex justify-content-center">
    <div class="p-4 shadow border rounded">
        <h3 class="mb-4">Create Thread</h3>
        <?php if ($res['thread-create-form']['error']) : ?>
            <section class="">
                <div class="text-danger">Error</div>
                <div class="text-danger"><?= $res['thread-create-form']['message'] ?></div>
            </section>
        <?php else : ?>
            <form method="post" class="">
                <input type="hidden" name="current_form" value="thread-create-form">

                <div class="row mb-3">
                    <label for="forum" class="col-sm-3 col-form-label">Forum</label>
                    <div class="col-sm-9">
                        <select name="forum" class="form-select" aria-label="forum select">
                            <option value='' selected>Select forum</option>
                            <?php foreach ($res['thread-create-form']['forums'] as $forum) : ?>
                                <option value="<?= $forum['id'] ?>"><?= $forum['title'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <?php if ($validation['thread-create-form']['forum']['error']) : ?>
                        <div class="text-danger"><?= $validation['thread-create-form']['forum']['message'] ?></div>
                    <?php endif ?>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" value="<?= isset($email) ? $email : '' ?>">
                    </div>
                    <?php if ($validation['thread-create-form']['email']['error']) : ?>
                        <div class="text-danger"><?= $validation['thread-create-form']['email']['message'] ?></div>
                    <?php endif ?>
                </div>

                <div class="row mb-3">
                    <label for="title" class="col-sm-3 col-form-label">Title</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="<?= isset($title) ? $title : '' ?>">
                    </div>
                    <?php if ($validation['thread-create-form']['title']['error']) : ?>
                        <div class="text-danger"><?= $validation['thread-create-form']['title']['message'] ?></div>
                    <?php endif ?>
                </div>

                <div class="row mb-3">
                    <label for="content" class="col-sm-3 col-form-label">Content</label>
                    <div class="col-sm-9">
                        <textarea name="content" class="form-control" aria-label="post content"><?= isset($content) ? $content : '' ?></textarea>
                    </div>
                    <?php if ($validation['thread-create-form']['content']['error']) : ?>
                        <div class="text-danger"><?= $validation['thread-create-form']['content']['message'] ?></div>
                    <?php endif ?>
                </div>

                <div>
                    <input type="submit" value="Submit">
                </div>
            </form>
        <?php endif ?>
    </div>
</section>