<?php

class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }
    //Получить строку запроса ,  Return request string
    private function getUri(){
        if (!empty($_SERVER['REQUEST_URI'])) {
            return  trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        //print_r($this->routes);
        //echo 'Class Router , method run';
        //Получить строку запроса
        $uri = $this->getUri();

        //Проверить наличие такого запроса in router.php
        foreach ($this->routes as $uriPattern => $path){
//            echo "<br> $uriPattern -> $path";

            // Сравнивает $uriPattern and $uri
            if (preg_match("~$uriPattern~", $uri))
            {

//                echo '<br>Где ищем(запрос, который набрал пользователь ): ' ."$uri";
//                echo '<br>Что ищем(совпадения из правил): ' ."$uriPattern";
//                echo '<br>Кто обрабатывает: ' ."$path";

                //Получаем внутрений путь из внешнего согласно правилу.

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

//                echo  '<br> нужно сформирировать: ' .$internalRoute;


                // Проверить какой контроллер и action обрабатывает запрос

                $segments = explode("/", $path);
//                echo '<pre>';
//                print_r($segments);
//                echo '<pre>';

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'. ucfirst(array_shift($segments));

//                    echo '<br> Класс: '. $controllerName;
//                    echo '<br> Метод: '. $actionName;

                $parameters = $segments;
//                echo '<pre>';
//                print_r($parameters);

                        //Подключаем файл класса контроллер
                $controllerFile = ROOT . '\\controllers\\' .$controllerName. '.php';

                if (file_exists($controllerFile)){
                   include_once($controllerFile);
                }

                // Создать объект класса контроллер и вызвать метод(action)

                $controllerObject = new $controllerName;

                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result != null){
                    break;
                }

            }
        }



    }

}