<?php

return [
    //public routes
    'login' => ['user', 'login', false],
    'logInn' => ['user', 'logInn', false],
    'register' => ['user', 'regForm', false], 
    'regStudent' => ['user', 'regStudent', false],
    
    //private user routes
    'home' => ['user', 'home', true],

    //admin routes
    'admin/dashboard' => ['admin', 'dashboard', true],
    'admin/pendingStudent' => ['admin', 'pendingStudent', true],
    'admin/approveStudent' => ['admin', 'approveStudent', true],
    'admin/approvedStudent' => ['admin', 'approvedStudent', true],
    'admin/rejectStudent' => ['admin', 'rejectStudent', true]
];