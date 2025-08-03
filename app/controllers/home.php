<?php

$heading = 'Home Page';

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);


// TODO - reasearch forums fetch possible errors, and how they affect app, and if I should make something like - 
// $res[$current_partial]['forums'] / $res[$current_partial]['error']
// if assuming we want to have multiple partial views which can also be multiple forms



$res = array(
    'forum-list' => array('error' => false, 'message' => 'Template error message')
);

$validation = array(
    'forum-create-form' => array(
        'title' => array('error' => false, 'message' => '')
    )
);


$forums = $db->query('SELECT * FROM Forums')->find();

if (count($forums) < 1) {
    $res['forum-list']['error'] = true;
    $res['forum-list']['message'] = 'No forums found';
} else $res['forum-list']['forums'] = $forums;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_form']) && $_POST['current_form'] == 'forum-create-form') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);

    $validation['forum-create-form']['title']['value'] = $title;

    if (!Validator::string($title)) {
        $validation['forum-create-form']['title']['error'] = true;
        $validation['forum-create-form']['title']['message'] = "Title is required";
    } else if (check_forum_exists_by_title($db, $title)) {
        $validation['forum-create-form']['title']['error'] = true;
        $validation['forum-create-form']['title']['message'] = "Title already exists";
    }

    if (!has_validation_errors($validation['forum-create-form'])) {
        if (create_forum($db, $title)) {
            // TODO: success flash message
        } else {
            // TODO: error flash message
        }
        Header("Location: " . 'http://localhost/proj-php/php-sql-exercise/php-with-routing-classes-oop/public' . '/');
        exit;
    }
}

function create_forum($db, $title)
{
    $affected_rows = $db->query('INSERT INTO Forums (title) VALUES (?)', 's', [$title])->affected_rows();
    return $affected_rows > 0;
}

function check_forum_exists_by_title($db, $title): bool
{
    $forums = $db->query('SELECT * FROM Forums WHERE title = ?', 's', [$title])->find();
    return count($forums) > 0;
}



view(
    'home.view.php',
    [
        'heading' => $heading,
        'res' => $res,
        'validation' => $validation
    ]
);
