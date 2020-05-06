<?php

use PitouFW\Core\Persist;

if (isset($_SESSION['imp']) && Persist::exists('AdminUser', 'id', $_SESSION['imp'])) {
    $_SESSION['uid'] = $_SESSION['imp'];
    unset($_SESSION['imp']);

    header('location: ' . WEBROOT);
    die;
}

unset($_SESSION['uid']);
header('location: ' . WEBROOT . 'login');
die;