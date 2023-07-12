<?php
class Router
{
    protected static $routes = [];

    public static function add($uri, $method, $service)
    {
        self::$routes[] = [
            'uri' => $uri,
            'service' => $service,
            'method' => $method
        ];
    }

    public static function get($uri, $service)
    {
        self::add($uri, 'GET', $service);
    }
    public static function post($uri, $service)
    {
        self::add($uri, 'POST', $service);
    }
    public static function put($uri, $service)
    {
        self::add($uri, 'PUT', $service);
    }
    public static function delete($uri, $service)
    {
        self::add($uri, 'DELETE', $service);
    }
    public static function route($uri, $method)
    {
        foreach (self::$routes as $route) {
            if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                return $route['service'];
            }
        }
        self::abort();
    }
    protected static function abort($code = 404)
    {
        http_response_code($code);
        die();
    }
}
