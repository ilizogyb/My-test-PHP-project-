<?php
    /**
    * Application головний клас додатку
    * створює об'єкти, запускає маршрутизацію, вмикає потрібні контроллери
    * @autor Lizogyb Igor
    * @since 1.0
    */
    namespace Core;

    use \Core\Request\Request;
    use \Core\Router\Router;
    use \Core\Response\Response;
    use \Core\Model\Connection;
    use \Core\Registry\Registry;

    class Application {
        protected $config;
        const VIEW_PATH = '/src/MySystem/Views';

        public function __construct($params) {
            if (file_exists($params) && is_readable($params)) {
                $this->config = include($params);
                Registry::set('pdo', $this->config['pdo']);
            }
        }

        /**
      	* Головний метод класу, в який вкладено функціонал додатку
      	*
      	*/
        public function run() {
          $req = new Request();
          Registry::set('request', $req);
          $router = new Router($req, $this->config['routes']);
          $router = $router->run();

          $controller = $router['controller'];
          $action = $router['action'].'Action';
          $vars = $router['vars'];

          //run controller and action
          $response = $this->runController($controller, $action, $vars);
          $response->send();
        }

        /**
         * Метод для запуску потрібного контроллера, дії і передачі змінних
         * @param string $controller контроллер
         * @param array $controllerAction дія контроллера
         * @return string  $vars змінні
         */
        protected function runController($controller, $controllerAction, $vars) {
            if(class_exists($controller)) {
                $controller = new $controller;
                $refl = new \ReflectionClass($controller);
            }


            if ($refl->hasMethod($controllerAction)) {
                $method = new \ReflectionMethod($controller, $controllerAction);
                $params = $method->getParameters();

                if(empty($params)) {
                    $response = $method->invoke(new $controller);
                } else {
                    $response = $method->invokeArgs(new $controller, $vars);
                }
            } else {
                throw new \Exception("Method or controller not found");
            }
            return $response;
        }

    }
?>
