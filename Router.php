<?php
class Router
{
    protected static $routes = [];

    public static function add($uri, $method, $service, $params)
    {
        self::$routes[] = [
            'uri' => $uri,
            'service' => $service,
            'method' => $method,
            'params'=>$params
        ];
    }

    public static function get($uri, $service, $params = [])
    {
        self::add($uri, 'GET', $service, $params);
    }
    public static function post($uri, $service, $params = [])
    {   
        $params = [ 
            'data'=>$_POST];
        self::add($uri, 'POST', $service, $params);
    }
    public static function put($uri, $service,$params = [])
    {
        if(isset($_POST['_method']) && $_POST['_method'] === 'PUT'){
            $params = [ 
                'data'=>$_POST];
        self::add($uri,'PUT', $service, $params);
        }
    }
    public static function delete($uri, $service, $params = [])
    {
        self::add($uri, 'DELETE', $service, $params);
    }
    public static function route($uri, $method)
    {
       
        
        foreach (self::$routes as $route) {
            if ($route['method']==='POST' && $route['uri'] === $uri && !($route['params']['data'])){
                return [
                    'service' => $route['service'],
                    'params' => $route['params'],
                ]; 
            }
            if ($route['method']==='PUT' && $route['uri'] === $uri){
                return [
                    'service' => $route['service'],
                    'params' => $route['params'],
                ]; 
            }
            $pattern = str_replace('/', '\/', $route['uri']);
    
            $pattern = preg_replace('/\{(\w+)\}/', '(?<$1>\d+)', $pattern);
            if (preg_match("/^{$pattern}$/", $uri, $matches) && $route['method'] === strtoupper($method)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_numeric($key)) {
                        $params[$key] = intval($value);
                    }
                }

                return [
                    'service' => $route['service'],
                    'params' => $params,
                ];
            }
        }
    
        self::abort();
    }
    protected static function abort($code = 404)
    {
        http_response_code($code);
        die();
    }
    public static function printRoutes()
    {
        var_dump(self::$routes);
    }

}
