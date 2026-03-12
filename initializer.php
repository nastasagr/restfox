<?php

add_action('rest_api_init', function () {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');

    add_filter('rest_pre_serve_request', function ($served) {
        $request_uri = $_SERVER['REQUEST_URI'] ?? '';

        if (str_contains($request_uri, '/wp-json/restfox/v1/')) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
        }

        return $served;
    });
});

add_action('init', function () {
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    if (
        $_SERVER['REQUEST_METHOD'] === 'OPTIONS'
        && str_contains($request_uri, '/wp-json/restfox/v1/')
    ) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        status_header(200);
        exit;
    }
});
