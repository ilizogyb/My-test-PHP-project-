<?php
/**
 * Клас ResponseRedirect являється реалізацією
 * функціоналу перенаправлення
 *
 */

namespace Core\Response;

class ResponseRedirect extends Response
{
    protected $route;

    /**
     * Конструктор для Redirect Response
     * @param string $route роут
     */
    public function __construct($route)
    {
        $this->options['sendHeaders'] = true;
        $this->route = $route;
        $this->setStatusCode(303);
        $this->setHeader('Location', $this->route, true);
        $this->send();
    }

    /**
     * Метод для надсилання заголовків
     *
     */
    public function send() {
        $this->sendHeaders();
    }
}
?>
