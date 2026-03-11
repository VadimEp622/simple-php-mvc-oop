    <?php if ($flash_message) : ?>
        <section id="flash_message" data-timeout="3000" class="container my-5">
            <p class="text-danger"><?= $flash_message['status'] ?></p>
            <p class="text-danger"><?= $flash_message['content'] ?></p>
        </section>
    <?php endif ?>