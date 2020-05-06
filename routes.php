<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 18/11/2018
 * Time: 15:12
 */

const ROUTES = [
    'home' => 'home',
    'login' => 'login',
    'logout' => 'logout',
    'profile' => 'profile',
    'core' => [
        'users' => 'users',
        'apps' => 'apps',
        'alert' => 'alert'
    ],
    'console' => [
        'users' => 'users',
        'teams' => 'teams',
        'invitations' => 'invitations'
    ],
    'website' => [
        'pages' => 'pages'
    ],
    'admin' => [
        'users' => 'users',
        'roles' => 'roles',
        'invitations' => 'invitations',
        'permissions' => 'permissions'
    ],
    'api' => []
];