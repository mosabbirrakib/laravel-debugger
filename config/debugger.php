<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Debugger Enabled
    |--------------------------------------------------------------------------
    |
    | Enable or disable the debugger. When disabled, the middleware will not
    | inject the debug bar into responses.
    |
    */
    'enabled' => env('DEBUGGER_ENABLED', env('APP_DEBUG', false)),

    /*
    |--------------------------------------------------------------------------
    | Environment Restrictions
    |--------------------------------------------------------------------------
    |
    | Only enable the debugger in these environments. Leave empty to allow
    | in all environments (when enabled is true).
    |
    */
    'allowed_environments' => ['local', 'development', 'dev', 'testing'],

    /*
    |--------------------------------------------------------------------------
    | Collectors
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific data collectors. You can turn off collectors
    | you don't need to improve performance.
    |
    */
    'collectors' => [
        'request' => true,
        'route' => true,
        'queries' => true,
        'views' => true,
        'logs' => true,
        'performance' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Query Settings
    |--------------------------------------------------------------------------
    |
    | Configure query collector behavior.
    |
    */
    'queries' => [
        'max_queries' => 100,
        'explain_enabled' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Settings
    |--------------------------------------------------------------------------
    |
    | Configure log collector behavior.
    |
    */
    'logs' => [
        'max_logs' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Settings
    |--------------------------------------------------------------------------
    |
    | Customize the debug bar appearance.
    |
    */
    'ui' => [
        'position' => 'bottom', // bottom or top
        'theme' => 'dark', // dark or light
    ],

    /*
    |--------------------------------------------------------------------------
    | Except Routes
    |--------------------------------------------------------------------------
    |
    | Routes to exclude from debugging. Supports wildcards.
    |
    */
    'except' => [
        'debugger/*',
        '_debugbar/*',
    ],
];
