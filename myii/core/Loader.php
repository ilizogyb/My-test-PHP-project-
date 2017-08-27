<?php
   /**
   *
   * Клас для реалізації автозавантаження потрібних для системи
   * класів. Використовується шаблон Одинак
   *
   * @autor Lizogyb Igor
   * @since 1.0
   *
   */

    class Loader {
      protected static $instance;
      //карта для відповідності неймспейсу шляху в файловій системі
      protected $namespacesMap = array();

      private function construct() {}
      private function clone() {}

      public static function getInstance() {
        if (self::$instance == null) {
          self::$instance = new self();
        }
        return self::$instance;
      }

      public function register() {
          spl_autoload_register(array($this,'loadClass'));
      }

      public function unregister() {
          spl_autoload_unregister(array($this, 'loadClass'));
      }

      public function addNameSpacePath($nameSpace, $rootDir) {
          if(is_dir($rootDir)) {
            $nameSpace = trim($nameSpace, '\\');
            $this->namespacesMap[$nameSpace] = $rootDir;
            return true;
          }
          return false;
      }


      public function loadClass($class) {
          $pathParts = explode('\\', $class);

          if(is_array($pathParts)) {
              $namespace = array_shift($pathParts);
              if(!empty($this->namespacesMap[$namespace])) {
                   $filePath = $this->namespacesMap[$namespace] . '/' . implode('/', $pathParts) . '.php';
                   if(file_exists($filePath)) {
                       require_once $filePath;
                   } else {
                       throw new Error($class.' not found in : '.$filePath);
				           }
              } else {
                  return false;
              }
          }
      }

    }
 ?>
