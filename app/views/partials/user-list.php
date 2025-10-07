<section class="container my-5">
    <h3>User list</h3>
    <?php if ($res['user-list']['error']) : ?>
        <div class="d-flex gap-2">
            <p style="color: red;"><?= $res['user-list']['message'] ?></p>
            <?php if (isset($res['user-list']['users']) && count($res['user-list']['users']) < 1) : ?>
                <form action="user" method="post">
                    <input type="hidden" name="_method" value="POPULATE">
                    <button>Populate demo users</button>
                </form>
            <?php endif ?>
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Age</th>
                        <th scope="col">Phone</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($res['user-list']['users'] as $value) : ?>
                        <tr>
                            <th scope="row"><?= $value['id'] ?></th>
                            <td><?= $value['full_name'] ?></td>
                            <td><?= $value['email'] ?></td>
                            <td><?= $value['age'] ?></td>
                            <td><?= $value['phone_number'] ?></td>
                            <td>
                                <form action="user" method="post" class="d-flex justify-content-center">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</section>