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
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}
