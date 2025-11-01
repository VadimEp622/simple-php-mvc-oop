<?php

$heading = 'Thread Page';


use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);


// TODO: 
// * make sure $res threads array is sorted by creation date, and that first post is hero post
// * make a thread view


$res = array(
    'thread-index' => array('error' => false, 'message' => 'Template error message')
);

$query_validation = array(
    'thread_id' => array('error' => false, 'message' => '')
);

thread_index_query_validator($db, $query_validation, $res);




dd(array('res' => $res, 'query_validation' => $query_validation));




// ========== Auxiliary functions ==========
function thread_index_query_validator($db, &$query_validation, &$res)
{
    $thread_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // only allow digits (0-9) and plus (+) and minus (-)


    $query_validation['thread_id']['value'] = $thread_id;


    if (!Validator::id_int($thread_id)) {
        $query_validation['thread_id']['error'] = true;
        $query_validation['thread_id']['message'] = "Thread is required";
    }

    // INFO: if no query validation errors, get thread from database 
    if (!has_validation_errors($query_validation)) {
        if (get_thread_by_id($db, $res, $thread_id)) {
            // success
        } else {
            // error
        };
    }
}

function get_thread_by_id($db, &$res, $thread_id)
{
    // TODO: make a findOne function
    $thread = $db->query('SELECT * FROM Threads WHERE id = ?', 'i', [$thread_id])->find();

    if (count($thread) < 1) {
        $res['thread-index']['error'] = true;
        $res['thread-index']['message'] = 'Thread not found';
        return false;
    }

    $posts = $db->query('SELECT * FROM Posts WHERE thread_id = ?', 'i', [$thread_id])->find();
    if (count($posts) < 1) {
        $res['thread-index']['error'] = true;
        $res['thread-index']['message'] = 'Thread related posts not found';
        return false;
    }


    $res['thread-index']['thread'] = $thread[0];
    $res['thread-index']['posts'] = $posts;
    return true;
}


// ========== View ==========
view(
    'thread/index.view.php',
    [
        'heading' => $heading,
        'res' => $res
    ]
);
