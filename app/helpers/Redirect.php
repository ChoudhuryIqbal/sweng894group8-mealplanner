<?php

namespace Base\Helpers;

class Redirect{

    /**
     * Redirects to another controller method
     * @param  string $controllerName Destination controller's namespace
     * @param  string $methodName     Destination method's namespace
     * @param  array  $params         Parameters to pass to method
     * @return void
     */
    public static function toControllerMethod($controllerName, $methodName, $params = NULL){

        $queryStringParams = self::queryStringifyParams($params);

        header('Location: /'.$controllerName.'/'.$methodName.'/'.$queryStringParams);
        exit();
    }

    /**
     * Convert parameters to URL-friendly format
     * @param  array $params    URL parameters after controller method
     * @return string           URL-friendly string with parameters
     */
    private static function queryStringifyParams($params){
        if(!$params){
            return '';
        }
        return implode('/', $params);
    }

}
