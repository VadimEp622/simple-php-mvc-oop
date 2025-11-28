<section class="container my-5">
    <h3>Thread list</h3>
    <?php if ($res['thread-list']['error']) : ?>
        <div class="d-flex gap-2">
            <p style="color: red;"><?= $res['thread-list']['message'] ?></p>
        </div>
    <?php else : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Forum</th>
                    <th scope="col">Poster Email</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($res['thread-list']['threads'] as $value) : ?>
                    <tr>
                        <th scope="row">
                            <a href=<?php echo BASE_URI . '/thread' . '?id=' . $value['id'] ?>>
                                <?= $value['id'] ?>
                            </a>
                        </th>
                        <td>
                            <a href=<?php echo BASE_URI . '/thread' . '?id=' . $value['id'] ?>>
                                <?= $value['title'] ?>
                            </a>
                        </td>
                        <td><?= $value['forum_title'] ?></td>
                        <td><?= $value['poster_email'] ?></td>
                        <td>
                            <form action="thread" method="post" class="d-flex justify-content-center">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</section>