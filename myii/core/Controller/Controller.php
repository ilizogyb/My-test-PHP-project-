<?php
/**
 * Базовий клас контроллера додатку
 *
 */

namespace Core\Controller;

use Core\Response\Response;
use Core\Response\ResponseRedirect;
use Core\Renderer\Renderer;
use \Core\Registry\Registry;

abstract class Controller {
    private $model;
    private $view;

    /**
     * Метод для візуалізації контенту
     * @param string $layout ім'я шаблону
     * @param array $params змінні для шаблону
     * @return string вміст сторінки
     */
    public function render($layout, $content) {
        $renderer = new Renderer($layout, $content);
        return new Response($renderer->render());
    }

    /**
     * Метод для реалізації функції перенаправлення
     * @param string $route роут для перенаправлення
     * @param string $message повідомлення користувачу
     * @return Object ResponseRedirect
     */
    public function redirect($route, $message = null) {
       return new ResponseRedirect($route);
    }

    /**
     * Метод для отримання поточного запиту
     * @return Request поточний запит
     *
     */
    public function getRequest() {
        return Registry::get('request');
    }

}

 ?>
