<?php

return [
    'presence' => [
        'route_name' => 'presence',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'marks' => [
        'route_name' => 'marks',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'notes' => [
        'route_name' => 'notes',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'justifications' => [
        'route_name' => 'justifications',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'register' => [
        'route_name' => 'register',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'teachers' => [
        'route_name' => 'teachers',
        'visibility' => ['admin']
    ],
    'students' => [
        'route_name' => 'students',
        'visibility' => ['admin']
    ],
    'classes' => [
        'route_name' => 'classes',
        'visibility' => ['admin']
    ],
    'subjects' => [
        'route_name' => 'subjects',
        'visibility' => ['admin']
    ],
    'timetible' => [
        'route_name' => 'timetable',
        'visibility' => ['admin', 'teacher', 'student']
    ]
];