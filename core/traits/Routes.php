<?php

trait Routes
{
    public function register_routes()
    {
        register_rest_route('restfox/v1', '/themes', [
            'methods' => 'GET',
            'callback' => [$this, 'get_themes'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);

        register_rest_route('restfox/v1', '/plugins', [
            'methods' => 'GET',
            'callback' => [$this, 'get_plugins'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);

        register_rest_route('restfox/v1', '/plugins/disable', [
            'methods' => 'POST',
            'callback' => [$this, 'disable_plugin'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);

        register_rest_route('restfox/v1', '/plugins/uninstall', [
            'methods' => 'DELETE',
            'callback' => [$this, 'uninstall_plugin'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);

        register_rest_route('restfox/v1', '/users', [
            'methods' => 'GET',
            'callback' => [$this, 'get_users'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);

        register_rest_route('restfox/v1', '/posts', [
            'methods' => 'GET',
            'callback' => [$this, 'get_posts'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);

        register_rest_route('restfox/v1', '/posts/(?P<postID>\d+)', [
            'methods' => 'DELETE',
            'callback' => [$this, 'delete_post'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);

        register_rest_route('restfox/v1', '/login', [
            'methods' => 'POST',
            'callback' => [$this, 'login'],
            'permission_callback' => '__return_true',
            'args' => [
                'username' => [
                    'required' => true,
                    'type' => 'string',
                ],
                'password' => [
                    'required' => true,
                    'type' => 'string',
                ],
            ],
        ]);

        register_rest_route('restfox/v1', '/settings', [
            [
                'methods' => 'GET',
                'callback' => [$this, 'get_settings'],
                'permission_callback' => [$this, 'permissions_check'],
            ],

            [
                'methods' => 'POST',
                'callback' => [$this, 'update_settings'],
                'permission_callback' => [$this, 'permissions_check'],
                'args' => [
                    'site_name' => [
                        'required' => false,
                        'type' => 'string',
                    ],
                    'site_description' => [
                        'required' => false,
                        'type' => 'string',
                    ],
                ],
            ],
        ]);
    }
}
