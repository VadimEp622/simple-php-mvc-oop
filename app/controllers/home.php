<?php

$heading = 'Home Page';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


// TODO - reasearch forums fetch possible errors, and how they affect app, and if I should make something like - 
// $res[$current_partial]['forums'] / $res[$current_partial]['error']
// if assuming we want to have multiple partial views which can also be multiple forms


// TODO: forum create form

$res = array(
    'forum-list' => array('error' => false, 'message' => 'Template error message')
);


$forums = $db->query('SELECT * FROM Forums')->find();
// dd($forums);

if (count($forums) < 1) {
    $res['forum-list']['error'] = true;
    $res['forum-list']['message'] = 'No forums found';
} else $res['forum-list']['forums'] = $forums;




view(
    'home.view.php',
    [
        'heading' => $heading,
        'res' => $res
    ]
);
