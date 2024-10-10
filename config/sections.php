<?php

return [
    'dashboard' => [
        'section_name' => 'Presenze',
        'route_name' => 'dashboard',
        'calendar' => true,
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'marks' => [
        'section_name' => 'Voti',
        'route_name' => 'marks',
        'calendar' => true,
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'notes' => [
        'section_name' => 'Note disciplinari',
        'route_name' => 'notes',
        'calendar' => true,
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'justifications' => [
        'section_name' => 'Giustificazioni/Assenze',
        'route_name' => 'justifications',
        'calendar' => false,
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'plan' => [
        'section_name' => 'RegistroProfessori',
        'route_name' => 'plan',
        'calendar' => true,
        'visibility' => [
            'teacher' => ['get', 'put', 'post', 'delete'], 
            'student' => ['get']
        ]
    ],
    'teachers' => [
        'section_name' => 'Professori',
        'route_name' => 'teachers',
        'calendar' => false,
        'visibility' => []
    ],
    'students' => [
        'section_name' => 'Studenti',
        'route_name' => 'students',
        'calendar' => false,
        'visibility' => []
    ],
    'classes' => [
        'section_name' => 'Classi',
        'route_name' => 'classes',
        'calendar' => false,
        'visibility' => []
    ],
    'subjects' => [
        'section_name' => 'Materie',
        'route_name' => 'subjects',
        'calendar' => false,
        'visibility' => []
    ],
    'timetable' => [
        'section_name' => 'Orario',
        'route_name' => 'timetable',
        'calendar' => false,
        'visibility' => [
            'teacher' => ['get'], 
            'student' => ['get']
        ]
    ]
];