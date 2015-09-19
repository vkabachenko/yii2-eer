<?php
return [
    'student' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'updateStudent',
        ],
    ],
    'inspector' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'viewFaculty',
        ],
    ],
    'localAdmin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'updateFaculty',
            'inspector',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'createDeleteFaculty',
            'localAdmin',
            'student',
        ],
    ],
    'updateFaculty' => [
        'type' => 2,
        'ruleName' => 'isOwnFaculty',
    ],
    'viewFaculty' => [
        'type' => 2,
        'ruleName' => 'isOwnFaculty',
    ],
    'createDeleteFaculty' => [
        'type' => 2,
    ],
    'updateStudent' => [
        'type' => 2,
        'ruleName' => 'isOwnStudent',
    ],
];
