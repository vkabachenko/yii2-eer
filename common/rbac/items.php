<?php
return [
    'student' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'updateStudent',
            'viewProgramFiles',
        ],
    ],
    'inspector' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'viewFaculty',
            'viewProgramFiles',
        ],
    ],
    'localAdmin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'updateFaculty',
            'viewFaculty',
            'viewProgramFiles',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'createDeleteFaculty',
            'updateFaculty',
            'viewFaculty',
            'viewProgramFiles',
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
    'viewProgramFiles' => [
        'type' => 2,
        'ruleName' => 'isProgramFiles',
    ],
    'createDeleteFaculty' => [
        'type' => 2,
    ],
    'updateStudent' => [
        'type' => 2,
        'ruleName' => 'isOwnStudent',
    ],
];
