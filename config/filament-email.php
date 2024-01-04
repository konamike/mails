<?php

// config for RickDBCN/FilamentEmail
use RickDBCN\FilamentEmail\Filament\Resources\EmailResource;

return [

    'resource' => [
        'class' => EmailResource::class,
        'group' => 'Activities Log',
        'sort' => 2,
        'default_sort_column' => 'created_at',
        'default_sort_direction' => 'desc',
    ],

    'keep_email_for_days' => 60,
    'label' => 'Email Logs',
];
