<?php
/**
 * Клас реалізація підключення до бази данних
 *
 *
 */

namespace Core\Model;

use PDO;

use Core\Registry\Registry;

class Connection {
    /**
    * Опції PDO за замовчуванням для кожного з'єднання
     * @var array
    */
    static $PDO_OPTIONS = array(
    PDO::ATTR_CASE				=> PDO::CASE_LOWER,
    PDO::ATTR_ERRMODE			=> PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_ORACLE_NULLS		=> PDO::NULL_NATURAL,
    PDO::ATTR_STRINGIFY_FETCHES	=> false);

    public $connection;
    protected $connParam;

    /**
     * Ініціалізація данних для підключення до бази данних
     * @param string $dsn DNS рядок з параметрами для створення
     * підключення
     */
    public function __construct($param = null) {
      $config = Registry::get('pdo');

      if ($param === null) {
          $this->connParam = $config;
      } else {
          $this->connParam = $param;
      }

    }

    /**
     * Створення пыдключення до бази данних
     * 
     */
    public function createConnection(){
      try {
            $dbh = new PDO($this->connParam['dns'], $this->connParam['user'], $this->connParam['password'], self::$PDO_OPTIONS);
          } catch(PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
          }
      return $dbh;
    }
}
?>
