<?php


function base_path($path)
{
    return BASE_PATH . $path;
}

function remove_string_prefix($string, $prefix)
{
    if (substr($string, 0, strlen($prefix)) === $prefix) {
        return substr($string, strlen($prefix));
    }
    return $string;
}

function view($path, $attributes = [])
{
    // INFO: extract() - accepts an array, and turns that array into a set of variables,
    //      where the name of the variable is the "key", and the value of the variable is the "value" associated with the "key".
    //      used here to inherit selected variables from to the controller to the view.
    extract($attributes);
    require_once base_path('app/layout/layout.php');
}

function getNavlinks()
{
    return [
        ['uri' => '/', 'label' => 'Home'],
        ['uri' => '/about', 'label' => 'About'],
    ];
}

function has_validation_errors(array $validation): bool
{
    foreach ($validation as $field => $data) {
        if ($data['error']) {
            return true;
        }
    }
    return false;
}

// learning purposes
function dd($data)
{
    //    usage example:    
    // A: dd($inserted_id);
    // B: dd(array('id inserted succesfully', $inserted_id));
    
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}
