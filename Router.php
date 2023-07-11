<?php
class Router
{
    protected static $routes = [];

    public static function add($uri, $method, $controller)
    {
        self::$routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];
    }

    public static function get($uri, $controller)
    {
        self::add($uri, 'GET', $controller);
    }
    public static function post($uri, $controller)
    {
        self::add($uri, 'POST', $controller);
    }
    public static function put($uri, $controller)
    {
        self::add($uri, 'PUT', $controller);
    }
    public static function delete($uri, $controller)
    {
        self::add($uri, 'DELETE', $controller);
    }
    public static function route($uri, $method)
    {
        foreach (self::$routes as $route) {
            if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                return $route['controller'];
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
