<section class="container-sm my-5" style="max-width: 500px;">
    <h3>Forum list</h3>
    <?php if ($res['forum-list']['error']) : ?>
        <p style="color: red;"><?= $res['forum-list']['message'] ?></p>
    <?php else : ?>
        <ul class="list-group" id="forum-list">
            <?php foreach ($res['forum-list']['forums'] as $value) : ?>
                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center gap-5">
                    <div><?= $value['title'] ?></div>
                    <form action="forum" method="post" class="d-flex flex-row justify-content-center align-items-center">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                        <button class="btn border-0"><i class="bi bi-trash icon-danger" style="font-size: 1.5rem;"></i></button>
                    </form>
                </li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
</section>

<style>
    #forum-list li button:hover {
        cursor: pointer;
        color: rgb(255, 109, 109);
    }
</style>