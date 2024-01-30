<?php

return [
    'presence' => [
        'section_name' => 'Presenze',
        'route_name' => 'presence',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'marks' => [
        'section_name' => 'Voti',
        'route_name' => 'marks',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'notes' => [
        'section_name' => 'Note disciplinari',
        'route_name' => 'notes',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'justifications' => [
        'section_name' => 'Giustificazioni/Assenze',
        'route_name' => 'justifications',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'register' => [
        'section_name' => 'Registro Professori',
        'route_name' => 'register',
        'visibility' => ['admin', 'teacher', 'student']
    ],
    'teachers' => [
        'section_name' => 'Professori',
        'route_name' => 'teachers',
        'visibility' => ['admin']
    ],
    'students' => [
        'section_name' => 'Studenti',
        'route_name' => 'students',
        'visibility' => ['admin']
    ],
    'classes' => [
        'section_name' => 'Classi',
        'route_name' => 'classes',
        'visibility' => ['admin']
    ],
    'subjects' => [
        'section_name' => 'Materie',
        'route_name' => 'subjects',
        'visibility' => ['admin']
    ],
    'timetible' => [
        'section_name' => 'Orario',
        'route_name' => 'timetible',
        'visibility' => ['admin', 'teacher', 'student']
    ]
];