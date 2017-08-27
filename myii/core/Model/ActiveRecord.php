<?php
/**
* ActiveRecord клас реалізація роботи додатку з базою данних
*
*/

namespace Core\Model;

abstract class ActiveRecord {

    protected static $connection;
    protected $pk;
    public $id;
    protected $bindStr = '';

    public function __construct(Connection $connection=null, $pk = 'id') {
        if (null === $connection) {
              self::$connection = new Connection();
              self::$connection = self::$connection->createConnection();
         } else {
             self::$connection = $connection;
         }
         $this->pk = $pk;
    }

    /**
     * Магічний метод для отримання значення поля об'єкту
     * @param string $param назва властивості
     *
     */
    public function __get($param) {
        if(isset($this->$param)) {
            return $this->$param;
        } else die(ucfirst($param) . ' is unavailable property');
    }

    /**
     * Метод для створення пыдключення до бази даних
     * @return PDO object
     */
    public static function createConnection() {
         if (null === self::$connection) {
            self::$connection = new Connection();
            self::$connection = self::$connection->createConnection();
            $pdo = self::$connection;
        } else {
            $pdo = self::$connection;
        }
        return $pdo;
    }

    /**
     * Метод для видалення посту за його ідентифікатором
     * @param string $id ідентифікатор посту, який потрібно
     * видалити
     */
    public static function delete($id) {
        $pdo = self::createConnection();
        $stmt = $pdo->prepare('DELETE FROM ' . static::getTable() . ' WHERE id = ?');
        $stmt->execute(array($id));
        return true;
    }

    /**
     * Метод пошуку посту за його ідентифікатором, або виводу
     * всіх наявних постів
     * @param string $id ідентифікатор посту, якщо
     * $id == 'all' виводяться всі наявні пости
     * @return Post пост або масив постів
     */
    public static function find($id) {
        $pdo = self::createConnection();

        $result = null;
        if (preg_match("/^\d*$/",$id)) {
            $stmt = $pdo->prepare('SELECT * FROM ' . static::getTable() . ' WHERE id = ?');
            $stmt->execute(array($id));
            $result = $stmt->fetch(\PDO::FETCH_OBJ);
        } elseif($id === 'all') {
            $sql = 'SELECT * FROM ' . static::getTable();
            $stmt = $pdo->query($sql);
            $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        return $result;
    }

      /**
      * Метод для побудови частини SQL запиту
      * виконує приєднання данних із змінних у поля таблиці
      * @param string array $fields масив із полями таблиці
      * @param string array $values масив із данними для цих полів
      *
      * Приклад використання:
      * bind(array("title","content"), array("Test title","Test content"));
      *
      * Метод повернеться рядок:
      * `title`='Test title', `content`='Test content'
      *  який можна використовувати для побудови SQL запиту
      *
      * @return string рядок із частиною SQL запиту
      */
     public function bind($fields, $values) {
         $str = '';
         $i = 0;
         foreach($fields as $field) {
                 $str .= ' `'.$field.'`='.'\''.$values[$i++].'\''. ', ';
         }
         $str = substr($str, 0, -2);
         $this->bindStr = $str;
     }

     /**
      * Метод для отримання масиву ключів записів, які є в БД
      * використовується для збереження даних,
      * а саме в методі save()
      * для порівняння поточного ключа запису із
      * наявними в БД
      */
     public function getIDs() {
         $pdo = self::$connection;
         $sql = 'SELECT id FROM `' . $this->getTable() . '`';
         $stmt = $pdo->query($sql);
         $usersIds = $stmt->fetchAll(\PDO::FETCH_COLUMN);
         return $usersIds;
     }

     /**
      *
      *
      */
      public function save() {
        if('MySystem\Model\Product'=== get_class($this)) {
            $this->bind(array("producttitle", "productprice"), array($this->producttitle, $this->productprice));
        }
        if('MySystem\Model\Agent'=== get_class($this)) {
            $this->bind(array("fname", "lname"), array($this->fname, $this->lname));
        }
        if('MySystem\Model\Address'=== get_class($this)) {
            $this->bind(array("agentsid", "address"), array($this->agentsid, $this->address));
        }

        $pdo = self::createConnection();

        if(in_array($this->id, $this->getIDs())) {
            $sql ='UPDATE `' . $this->getTable() . '` SET' . $this->bindStr .'WHERE id = ' . $this->id;
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        } else {
            $sql ='INSERT INTO `' . $this->getTable() . '` SET' . $this->bindStr;
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $this->id = $pdo->lastInsertId();
        }

      }



}

?>
