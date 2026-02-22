<?php

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_input(): string
{
    return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
}

function csrf_verify(): bool
{
    return isset($_POST['_csrf'], $_SESSION['_csrf'])
        && hash_equals($_SESSION['_csrf'], $_POST['_csrf']);
}
