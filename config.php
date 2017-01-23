<?php

$config = [
    'title'     => 'Make a Quiz',

    'base'      => '/maq',

    'database'  => [
        'username'  => 'root',
        'password'  => '',
        'name'      => 'maq',
        'host'      => 'localhost'
    ],
    'question'  => [
        'categories'    => [
            'mc'    => 'Multiple Choice',
            'tf'    => 'True / False',
            'sa'    => 'Short Answer',
            'mt'    => 'Matching Type',
            'fb'    => 'Fill in the Blank',
            'cb'    => 'Checkboxes',
            'ew'    => 'Essay Writing'
        ]
    ],
    'roles'     => [
        'student',
        'teacher'
    ],
    'courses'   => [
        'ABM',
        'GAS',
        'HUMSS',
        'STEM',
        'TVL'
    ],
    'year_level'    => [
        1   => 'First Year',
        2   => 'Second Year'
    ],
    'days'       => [
        'M',
        'TH',
        'W',
        'T',
        'F',
        'S',
        'MWF',
        'TTH'
    ]
];
