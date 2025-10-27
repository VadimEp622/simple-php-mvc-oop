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



// ========== Forums form ==========
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



// ========== Forums list ==========
$forums = $db->query('SELECT * FROM Forums')->find();

if (count($forums) < 1) {
    $res['forum-list']['error'] = true;
    $res['forum-list']['message'] = 'No forums found';
} else $res['forum-list']['forums'] = $forums;



// ========== Users ==========
$users = $db->query('SELECT * FROM Users')->find();

if (count($users) < 1) {
    $res['user-list']['error'] = true;
    $res['user-list']['message'] = 'No users found';
} else $res['user-list']['users'] = $users;



// ========== Threads form ==========
if (count($forums) < 1) {
    $res['thread-create-form']['error'] = true;
    $res['thread-create-form']['message'] = 'No forums found';
} else $res['thread-create-form']['forums'] = $forums;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_form']) && $_POST['current_form'] == 'thread-create-form') {
    thread_form_validator($db, $validation);
}



// ========== Threads list ==========
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




// ========== Auxiliary functions (temporary?) ==========
function thread_form_validator($db, &$validation)
{
    $forum = filter_input(INPUT_POST, 'forum', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

    $validation['thread-create-form']['forum']['value'] = $forum;
    $validation['thread-create-form']['email']['value'] = $email;
    $validation['thread-create-form']['title']['value'] = $title;
    $validation['thread-create-form']['content']['value'] = $content;



    if (!Validator::id_int($forum)) {
        $validation['thread-create-form']['forum']['error'] = true;
        $validation['thread-create-form']['forum']['message'] = "Forum is required";
    } else if (!check_forum_exists_by_id($db, $forum)) {
        // incase forum was deleted from DB
        $validation['thread-create-form']['forum']['error'] = true;
        $validation['thread-create-form']['forum']['message'] = "Forum is invalid";
    }

    if (!Validator::string($email)) {
        $validation['thread-create-form']['email']['error'] = true;
        $validation['thread-create-form']['email']['message'] = "Email is required";
    } else if (!Validator::email($email)) {
        $validation['thread-create-form']['email']['error'] = true;
        $validation['thread-create-form']['email']['message'] = "Email is invalid";
    } else if (!check_user_exists_by_email($db, $email)) {
        $validation['thread-create-form']['email']['error'] = true;
        $validation['thread-create-form']['email']['message'] = "Email does not exist";
    }

    if (!Validator::string($title)) {
        $validation['thread-create-form']['title']['error'] = true;
        $validation['thread-create-form']['title']['message'] = "Title is required";
    }

    if (!Validator::string($content)) {
        $validation['thread-create-form']['content']['error'] = true;
        $validation['thread-create-form']['content']['message'] = "Content is required";
    }

    // TODO: if no validation errors, create thread and first post in database 
}


function create_forum($db, $title)
{
    $affected_rows = $db->query('INSERT INTO Forums (title) VALUES (?)', 's', [$title])->affected_rows();
    return $affected_rows > 0;
}

function check_user_exists_by_email($db, $email): bool
{
    $users = $db->query('SELECT * FROM Users WHERE email = ?', 's', [$email])->find();
    return count($users) > 0;
}

function check_forum_exists_by_title($db, $title): bool
{
    $forums = $db->query('SELECT * FROM Forums WHERE title = ?', 's', [$title])->find();
    return count($forums) > 0;
}

function check_forum_exists_by_id($db, $forum_id): bool
{
    $forums = $db->query('SELECT * FROM Forums WHERE id = ?', 'i', [$forum_id])->find();
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
