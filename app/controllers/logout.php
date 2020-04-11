<?php
unset($_SESSION['uid']);
header('location: ' . WEBROOT . 'login');
die;