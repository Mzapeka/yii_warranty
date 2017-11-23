<?php
return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'sign-up' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'view' => [
        'type' => 2,
    ],
    'update' => [
        'type' => 2,
    ],
    'delete' => [
        'type' => 2,
    ],
    'indexAdmin' => [
        'type' => 2,
    ],
    'gii' => [
        'type' => 2,
    ],
    'importdata' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'description' => 'Гость',
        'ruleName' => 'userGroup',
        'children' => [
            'login',
            'logout',
            'error',
            'sign-up',
            'index',
            'view',
        ],
    ],
    'dealer' => [
        'type' => 1,
        'description' => 'Диллер',
        'ruleName' => 'userGroup',
        'children' => [
            'update',
            'guest',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userGroup',
        'children' => [
            'delete',
            'dealer',
            'indexAdmin',
            'gii',
            'importdata',
        ],
    ],
];
