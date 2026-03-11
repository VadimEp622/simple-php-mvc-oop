<?php

use Core\App;
use Core\Database;
use Core\Flash;

$db = App::resolve(Database::class);
$flash = App::resolve(Flash::class);

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT); // only allow digits (0-9) and plus (+) and minus (-)

if (empty($id)) {
    dd('id is empty');
    // TODO: handle fault case
}

if (delete_forum($db, $id)) {
    // TODO: success flash message
    $flash->set('success', 'Forum delete success');
} else {
    // TODO: error flash message
    $flash->set('failed', 'Forum delete failed');
}

function delete_forum($db, $id)
{
    $affected_rows = $db->query('DELETE FROM Forums WHERE id = ?', 'i', [$id])->affected_rows();
    return $affected_rows > 0;
}

Header("Location: " . 'http://localhost/proj-php/php-sql-exercise/php-with-routing-classes-oop/public' . '/');
exit;
