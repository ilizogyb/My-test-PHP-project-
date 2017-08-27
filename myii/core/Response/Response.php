<?php
/**
 * Клас реалізація HTTP Response
 *
 */
namespace Core\Response;

class Response {
    // HTTP статус коди і повідомлення
    public static $httpStatuses = [
      // Інформаційні 1xx
      100 => 'Continue',
      101 => 'Switching Protocols',
      102 => 'Processing',
      118 => 'Connection timed out',

      // Успішні операції 2xx
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      203 => 'Non-Authoritative',
      204 => 'No Content',
      205 => 'Reset Content',
      206 => 'Partial Content',
      207 => 'Multi-Status',
      208 => 'Already Reported',
      210 => 'Content Different',
      226 => 'IM Used',

      // Перенаправлення 3xx
      300 => 'Multiple Choices',
      301 => 'Moved Permanently',
      302 => 'Found',
      303 => 'See Other',
      304 => 'Not Modified',
      305 => 'Use Proxy',
      306 => 'Reserved',
      307 => 'Temporary Redirect',
      308 => 'Permanent Redirect',
      310 => 'Too many Redirect',
      // Поилки клієнта 4xx
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      406 => 'Not Acceptable',
      407 => 'Proxy Authentication Required',
      408 => 'Request Time-out',
      409 => 'Conflict',
      410 => 'Gone',
      411 => 'Length Required',
      412 => 'Precondition Failed',
      413 => 'Request Entity Too Large',
      414 => 'Request-URI Too Long',
      415 => 'Unsupported Media Type',
      416 => 'Requested range unsatisfiable',
      417 => 'Expectation failed',
      418 => 'I\'m a teapot',
      422 => 'Unprocessable entity',
      423 => 'Locked',
      424 => 'Method failure',
      425 => 'Unordered Collection',
      426 => 'Upgrade Required',
      428 => 'Precondition Required',
      429 => 'Too Many Requests',
      431 => 'Request Header Fields Too Large',
      449 => 'Retry With',
      450 => 'Blocked by Windows Parental Controls',
      // Помилки сервера 5xx
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      502 => 'Bad Gateway or Proxy Error',
      503 => 'Service Unavailable',
      504 => 'Gateway Time-out',
      505 => 'HTTP Version not supported',
      507 => 'Insufficient storage',
      508 => 'Loop Detected',
      509 => 'Bandwidth Limit Exceeded',
      510 => 'Not Extended',
      511 => 'Network Authentication Required',
    ];

    private $_statusCode = 200;
    private $_headers;
    protected $content;
    public $statusText = 'OK';
    protected $options = array();

    public function __construct($content, $msg = '', $code = 200) {
        $this->content = $content;
        $this->statusText = $msg;
        $this->_statusCode = $code;

        // Встановлення можливості відправки HTTP заголовків, та кук
        $this->options['sendHeaders'] = true;
    }

    /**
     * Метод для отримання версії HTTP протоколу
     * @return string версія протоколу
     */
    public function getHTTPver() {
        if (isset($_SERVER['SERVER_PROTOCOL']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.0') {
			return '1.0';
        } else {
           return '1.1';
        }
    }

    /**
     * Метод для отримання статус коду
     * @return рядок і значеням статус коду
     */
    public function getStatusCode() {
        return $this->_statusCode;
    }

    /**
     * Метод для встановлення статус коду
     * @param int $value тризначне число із значенням коду
     * @param string $text рядок із поясненням значення коду
     */
    public function setStatusCode($value, $text = null) {
    		if ($value === null) {
                $value = 200;
            }
             $this->_statusCode = (int) $value;
            if ($text === null) {
    			 $this->statusText = isset(static::$httpStatuses[$this->_statusCode]) ? static::$httpStatuses[$this->_statusCode] : '';
            } else {
    			$this->statusText = $text;
    		}
	  }

    /**
     * Метод для нормалізації  заголовків
     * @param string $name назва заголовку
     * @return string нормалізований заголовок
     */
    protected function normalizeHeaderName($name) {
        return preg_replace_callback(
                  '/\-(.)/',
                  function ($matches) {
                    return '-'.strtoupper($matches[1]);
                  },
                  strtr(ucfirst(strtolower($name)), '_', '-')
        );
    }


    /**
     * Метод для отримання поточного значення заголовку
     * @param string $name назва заголовку
     * @return string рядок із значенням заголовку
     */
    public function getHeader($name) {
         $name = $this->normalizeHeaderName($name);
         return isset($this->_headers[$name]) ? $this->_headers[$name] : null;
     }

    /**
     * Метод для отримання заголовків з поточного response
     * @return масив із рядками заголовків
     */
     public function getHeaders() {
        return $this->_headers;
     }

    /**
     * Метод для встановлення HTTP заголовків.
     * @param string  $name ім'я заголовку
     * @param string  $value    значення(вставіть null для видалення заголовку)
     * @param bool    $replace  зміна значення
     */
    public function setHeader($name, $value, $replace = true) {

         $name = $this->normalizeHeaderName($name);
         //Знищуємо заголовок якщо значеня відсутнє
         if ($value == null) {
             unset($this->headers[$name]);
             return;
         }

         if($name == 'Content-Type')
         {
             if ($replace || !$this->getHeader('Content-Type')) {
                 $this->setContentType($value);
             }
             return;
         }

         if (!$replace)
         {
            $current = isset($this->headers[$name]) ? $this->headers[$name] : '';
            $value = ($current ? $current.', ' : '').$value;
         }
         $this->_headers[$name] = $value;
       }

    /**
     * Метод для відправки заголовків і кук в HTTP клієнт, посилає заголовки і куки
     * тільки один раз, наступні виклики методу не виконуватимуть ніяких дій
     */
    protected function sendHeaders() {
        //заголовки
        if(count($this->_headers) === 0 || !$this->options['sendHeaders']) {
            return;
        }

        $statusCode = $this->getStatusCode();
        header("HTTP/{$this->getHTTPver()} $statusCode {$this->statusText}");
        foreach($this->_headers as $name => $value) {
            header($name.': '.$value);
        }

        //Запобігання повторній пересилці заголовків
        $this->options['sendHeaders'] = false;
    }

    /**
     * Метод для відправки заголовків та контенту в HTTP клієнт
     *
     */
    public function send() {
         $this->sendHeaders();
         echo  $this->getContent();
     }

    /**
    * Метод для отримання контенту поточного response.
    * @retutn string  контент поточного response
    */
    public function getContent()  {
       return $this->content;
    }

    /**
    * Метод для встановлення контенту поточного response.
    * @param $content string  контент поточного response
    */
    public function setContent($content) {
       $this->content = $content;
    }
}
 ?>
