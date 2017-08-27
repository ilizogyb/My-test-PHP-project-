<?php
    /**
     * Router реалызація маршрутизаціїї в додатку
     *
     * @autor Lizogyb Igor
     * @since 1.0
     */
    namespace Core\Router;

    class Router {
      protected $_url;
      protected $map;

      public function __construct($request, $routesMap) {
          $this->_url = $request->getUrl();
          $this->map = $routesMap;
      }
    /**
    * Метод для отримання патерну для розбору роутів
    * @param string array $routes масив з потрібним патерном, контроллером
    * дією, та змінними
    * @return string патерн для розбору роутів
    */
      public function prepareRegExp($route) {
          $pattern = '/\{[\w\d_]+\}/Ui';
          $replacement = '\d+';
          preg_match_all($pattern, $route['pattern'], $matches);
          $str = str_replace($matches[0], $replacement, $route['pattern']);
          return $str;
      }


      /**
       * Головний метод класу, який запускає процес маршрутизації
       * шукає та повертає контроллер, дію та параметри(змінні)
       * @return mixed
       *
      */
      public function run() {
        if(!is_null($this->map)) {
          foreach ($this->map as $key=>$value) {
            if(strrpos($value['pattern'], '{')) {
              if(preg_match('~^'.$this->prepareRegExp($value).'$~',  $this->_url)) {
                $vars = explode('/', $this->_url)[3];
                $routes['controller'] = $value['controller'];
                $routes['action'] = $value['action'];
                $routes['vars'] = [$vars];
              }
            } else {
                if(preg_match('~^'.$value['pattern'].'$~',  $this->_url)) {
                  $routes['controller'] = $value['controller'];
                  $routes['action'] = $value['action'];
                  $routes['vars'] = [null];
                }
            }

          }
          return $routes;
         }
      }
    }

 ?>
