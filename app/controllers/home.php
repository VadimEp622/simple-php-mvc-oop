<?php

$heading = 'Home Page';

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);


// TODO - reasearch forums fetch possible errors, and how they affect app, and if I should make something like - 
// $res[$current_partial]['forums'] / $res[$current_partial]['error']
// if assuming we want to have multiple partial views which can also be multiple forms


// TODO - add user populate
// TODO - add thread list/form

// TODO: consider - in Thread DB Table, should the "content" field exist as a string there?
//      maybe it's better to tie first post (Post DB Table) to the thread as an identifier?
//      also to consider - what can/should actually be deleted and by whom? 
//      first post is always tied to it's related thread, so one can never be removed without the other.
//      can thread creator, aka first post creator, remove/delete a thread? or is it an action that must only be done by an admin? 
//      because a thread does not belong to poster itself anymore, since other people post on it...
//      should 2nd post onwards be able to be removed by the poster? It should definitely be possible to EDIT it, at the very least...

// INFO: my decision - make ALL post be in DB Post Table.

// TODO: make thread form validation + db insert




$res = array(
    'forum-list' => array('error' => false, 'message' => 'Template error message'),
    'user-list' => array('error' => false, 'message' => 'Template error message'),
    'thread-create-form' => array('error' => false, 'message' => 'Template error message'),
    'thread-list' => array('error' => false, 'message' => 'Template error message')
);

$validation = array(
    'forum-create-form' => array(
        'title' => array('error' => false, 'message' => '')
    ),
    'thread-create-form' => array(
        'title' => array('error' => false, 'message' => ''),
        'content' => array('error' => false, 'message' => ''),
        'forum' => array('error' => false, 'message' => ''),
        'email' => array('error' => false, 'message' => '')
    )
);



// ========== Forums ==========
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



// ========== Users ==========
$users = $db->query('SELECT * FROM Users')->find();

if (count($users) < 1) {
    $res['user-list']['error'] = true;
    $res['user-list']['message'] = 'No users found';
} else $res['user-list']['users'] = $users;



// ========== Threads ==========
$threads = $db->query('SELECT
        Threads.id,
        Threads.title,
        COALESCE(Forums.title, Threads.forum_id) AS forum_title,
        Threads.poster_email
    FROM
        Threads
    LEFT JOIN Forums ON Threads.forum_id = Forums.id')->find();

if (count($threads) < 1) {
    $res['thread-list']['error'] = true;
    $res['thread-list']['message'] = 'No threads found';
} else $res['thread-list']['threads'] = $threads;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_form']) && $_POST['current_form'] == 'thread-create-form') {
    echo 'hi from home page\'s thread create validator';
}



// ========== Auxiliary functions (temporary?) ==========
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



// ========== View ==========
view(
    'home.view.php',
    [
        'heading' => $heading,
        'res' => $res,
        'validation' => $validation
    ]
);
