<?php

return [
    'dashboard' => [
        'section_name' => 'Presenze',
        'route_name' => 'dashboard',
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'marks' => [
        'section_name' => 'Voti',
        'route_name' => 'marks',
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'notes' => [
        'section_name' => 'Note disciplinari',
        'route_name' => 'notes',
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'justifications' => [
        'section_name' => 'Giustificazioni/Assenze',
        'route_name' => 'justifications',
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'register' => [
        'section_name' => 'Registro Professori',
        'route_name' => 'register',
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'teachers' => [
        'section_name' => 'Professori',
        'route_name' => 'teachers',
        'visibility' => []
    ],
    'students' => [
        'section_name' => 'Studenti',
        'route_name' => 'students',
        'visibility' => []
    ],
    'classes' => [
        'section_name' => 'Classi',
        'route_name' => 'classes',
        'visibility' => []
    ],
    'subjects' => [
        'section_name' => 'Materie',
        'route_name' => 'subjects',
        'visibility' => []
    ],
    'timetible' => [
        'section_name' => 'Orario',
        'route_name' => 'timetible',
        'visibility' => [
            'teacher' => ['get'], 
            'student' => ['get']
        ]
    ]
];