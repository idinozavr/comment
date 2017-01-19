<?php

class Router
{
    /**
     * Переменная для записи массива маршрутов
     * @var array
     */
    protected $routes;

    /**
     * Конструктор подключает массив маршрутов
     */
    function __construct()
    {
        $routerPath = ROOT.'/config/routes.php';
        $this->routes = include_once ($routerPath);
    }

    /**
     * Подключаем нужный контроллер и метод
     */
    public function run()
    {
        # Получаем часть URL страницы без домена.
        if (!empty($_SERVER['REQUEST_URI'])) {
            $url = trim($_SERVER['REQUEST_URI'], '/');
        }

        # Перебираем массив маршрутов и подключаем нужный контроллер с нужным методом.
        foreach ($this->routes as $key => $route) {

            # Если URL соответствует маршруту.
            if($key == $url){

                $segments = explode('@', $route);
                $controllerName = $segments[0];
                $actionName = $segments[1];

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if(file_exists($controllerFile)){
                    include_once "$controllerFile";
                }

                $controllerObj = new $controllerName;
                $controllerObj->$actionName();
            }
        }
    }
}