<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class JwtMiddleware
{
    public function handle(Closure $next)
    {
        $lava = &get_instance();
        $lava->call->library('Api');

        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $lava->api->unauthorized('Access denied. No token provided.');
            exit;
        }

        $token = $matches[1];
        $decoded = $lava->api->verifyToken($token);

        if (!$decoded) {
            $lava->api->unauthorized('Invalid or expired token.');
            exit;
        }

        // Pass authenticated user data to request context if needed
        $lava->authenticated_user = $decoded;

        return $next();
    }
}