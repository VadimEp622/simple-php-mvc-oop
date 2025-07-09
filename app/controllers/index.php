<?php

$heading = 'Home Page';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$forums = $db->query('SELECT * FROM Forums')->find();
dd($forums);

view(
    'index.view.php',
    ['heading' => $heading]
);
