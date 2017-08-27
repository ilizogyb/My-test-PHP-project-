<?php
/**
 * Клас Request являється HTTP запитом
 *
 *
 */

namespace Core\Request;

class Request {
    private $_url;
    private $_part = array();

    public function __construct($url = null) {
      if($url === null) {
          $url = $_SERVER['REQUEST_URI'];
      }
      $this->_url = urldecode($url);
    }

    /**
     * Метод повертає URL запиту
     * @return string рядок уніфікований локатор
     *
     */
    public function getUrl() {
        return $this->_url;
    }


    /**
     * Повертає метод поточного запиту GET, POST, HEAD, PUT, DELETE
     * @return Метод повертає рядок, наприклад, GET, POST, HEAD, PUT, DELETE.
     * Значення, що повертається перетворився у верхньому регістрі.
     */
     public function getMethod() {
         if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
             return strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
         } else {
             return isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
         }
     }



      /**
       * Метод повертає істину, якщо тип запиту POST
       * @return boolean булеве значення, в залежності від типу запиту
       *
       */
        public function isPost() {
            return $this->getMethod() === 'POST';
        }
        /**
         * Метод повертає істину, якщо тип запиту GET
         * @return boolean булеве значення, в залежності від типу запиту
         *
         */
        public function isGet() {
            return $this->getMethod() === 'GET';
        }


        /**
         * Метод повертає параметри із запиту методом GET
         * @param string $key рядок із ключем для пошуку
         * @param string $default значення параметра
         */
        public function get($key,$default = null) {
            if($this->isGet()) {
               $result = isset($_GET[$key]) ? $this->filter($_GET[$key]) : $default;
               return $result;
            }
        }

        /**
         * Метод повертає параметри із запиту методом POST
         * @param string $key рядок із ключем для пошуку
         * @param string $default значення параметра
         */
        public function post($key, $default = null) {
            if($this->isPost()) {
                $result = isset($_POST[$key]) ? $this->filter($_POST[$key]) : $default;
                return $result;
            }
        }

        /**
         * Метод виконує фільтрацію вхідних даних запиту
         * @param string $value вхідні данні для фільтрації
         * @return string $text відфільтровані дані
         *
         */
        protected function filter($value) {
            if (strlen($value)){
                $text = trim($value);
                $pattern = '/<\s*\/*\s*\w*>|[\$`~#<>\[\]\{\}\\\*\^%]/';
                $text = preg_replace($pattern, "", $text);
                $text = htmlspecialchars($text);
            } else {
                return false;
            }
            return $text;
        }
}
