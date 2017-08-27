<?php
 /**
  * клас Registry реалізація реєстра сервісів
  *
  *
  */

namespace Core\Registry;

class Registry {

    protected static $instance = null;
    protected static $service = array();

  	/**
     * Закриваємо доступ до функції поза класом.
     *
     */
    private function __construct(){

    }

    /**
     * Закриваємо доступ до функції поза класом.
     *
     */
    private function __clone(){}

    /**
     * Статична функція, яка повертає
     * екземпляр класу або створює новий за
     * необхідності
     *
     * @return Object Registry
     */
    public static function getInstance() {
        if(null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Метод для додавання сервісу в  реєстр
     * @param string $name назва сервісу
     * @param string $service опис сервісу
     * @param string $share доступність
     */
    public function set($name, $service) {
        self::$service[$name] = $service;
    }

    /**
     * Метод для перевірки існування сервісу в реєстрі
     * @param string $name назва сервісу
     * @return boolean булеве значення істиності якщо сервіс наявний
     */
  	public function has($name) {
  		return (isset(self::$service[$name]));
  	}

    /**
     * Метод для отримання сервісу з реєстра
     * @param string $name назва сервісу
     * @return потрібний сервіс
     */
    public function get($name) {
        return self::$service[$name];
    }

    /**
     * Метод для отримання усіх сервісів з реєстра
     * @param string $name назва сервісу
     * @return Object array сервіси які наявні в реєстрі
     */
    public function getAll() {
        return self::$service;
    }
}
?>
