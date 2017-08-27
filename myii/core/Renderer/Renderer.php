<?php
/**
 * Клас реалізація рендера для візуалізації контенту
 *
 */

namespace Core\Renderer;
use Core\Application;

class Renderer {

    private $path = '';
    private $viewFiles = [];
    public $defaultExtension = 'php';
    protected $data = array();
    protected $layout;

    /**
     * Конструктор для ініціалізації Візуалізптора
     * @param string $layout потрібний шаблон
     * @param array $data змінні для передачі в шаблон
     *
     */
    public function __construct($layout, $data) {
        $this->data = $data;

        if (file_exists($layout)){
            $this->layout = $layout;
        } else {
            $this->path = $_SERVER['DOCUMENT_ROOT'] . Application::VIEW_PATH;
            $this->layout = $this->findView($layout);
        }
    }

    /**
     * Метод для отримання масиву з даними
     * про шляхи шаблонів та їх назви
     * @param string $templatePath рядок із шляхом
     * до папки з шаблонами
     * @return array string інформація про шаблони та шляхи до них
     */
    protected function getTemplatesInfo($templatePath) {
        $res = scandir($templatePath);
        $files = array();

        foreach($res as $value) {
            if(!in_array($value, array('.', '..'))) {
                if(!is_dir($templatePath . DIRECTORY_SEPARATOR . $value)) {
                    $files[$value] = $templatePath . '/' .$value;
                } else {
                    $path = $templatePath . DIRECTORY_SEPARATOR . $value . DIRECTORY_SEPARATOR;
                    $files[$value] = $this->getTemplatesInfo($path);
                }
            }
        }
        return $files;
    }


    /**
     * Метод для отримання списку наявних шаблонів із їхнім шляхом
     * @param array string $files масив з даними про шляхи та назви шаблонів
     * @return array string список з назвами шаблонів та шляхами до них
     */
     public function getTemplateFilesList() {
        $files = $this->getTemplatesInfo($this->path);
        $templFiles  = array();
        foreach($files as $key => $value) {
            if(!is_array($value)) {
                $templFiles[str_replace(".php", "", $key)] = $value;
            } else {
                foreach($value as $key=>$value) {
                    $templFiles[str_replace(".php", "", $key)] = str_replace(["\\", "\/"], DIRECTORY_SEPARATOR, $value);
                }
            }
        }
        $this->viewFiles =  $templFiles;
      }


    /**
     * Метод пошуку потрібного шаблону
     * @param string $view назва шаблону
     * @return string шлях до потрібного шаблону
     * @throw FileException якщо потрібного шаблону не знайдено
     */
    public function findView($view) {

        //Отримуємо список шаблонів з їхніми шляхами
        $this->getTemplateFilesList();

        if(isset($this->viewFiles[$view])) {
            return $this->viewFiles[$view];
        } else {
            throw new \Exception("File with template not Found");
        }
    }

    /**
     * Метод для візуалізації контенту з php файлу
     * @param string $_file ім'я файлу
     * @param array $_params параметри які потрібно передати в шаблон
     * @return string  вміст сторінки
     */
    public function render() {
        //старт буферизація виводу
        ob_start();
        //вимкнення неявного очищення буфера після кожного виводу
        ob_implicit_flush(false);
        //імпорт змінних з масиву в поточну символьну таблицю
        extract($this->data, EXTR_OVERWRITE);
        //підключаємо головний шаблон
        include $this->layout;
        //Очищаємо буфер виводу
        ob_end_flush();

    }

}

 ?>
