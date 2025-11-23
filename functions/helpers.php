<?php

// config
// change project folder 
$projectFolder = '/php_blog';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

define('BASE_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . $projectFolder . '/');

// Define helpers

function redirect($URL)
{
    header("Location: " . trim(BASE_URL, '/ ') . '/' . trim($URL, '/ '));
    exit;
}

function asset($FILE)
{
    return trim(BASE_URL, '/ ') . '/' . trim($FILE, '/ ');
}

function url($URL)
{
    return trim(BASE_URL, '/ ') . '/' . trim($URL, '/ ');
}

function dd($VARIABLE)
{    // DUMP FOR DEBUG
    echo '<pre>';
    var_dump($VARIABLE);
    exit;
}
