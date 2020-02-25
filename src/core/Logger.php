<?php

namespace Flowee\Core;
use Psr\Log\LoggerInterface;
use Flowee\Core\Timer;
use Psr\Log\InvalidArgumentException;

class Logger implements LoggerInterface {

  /**
   * Detailed bug informationg
   */
  public const DEBUG = 100;

  /**
   * Events
   * like: User logs, SQL logs
   */
  public const INFO = 200;

  /**
   * Uncommon events
   */
  public const NOTICE = 250;
  
  /**
   * Exceptional occurrences that not are errors
   */
  public const WARNING = 300;
  
  /**
   * Runtime errors
   */
  public const ERROR = 400;

  /**
   * Critical conditions
   */
  public const CRITICAL = 500;

  /**
   * Action must be taken immediatly
   */
  public const ALERT = 550;

  /**
   * Urgent alerting
   */
  public const EMERGENCY = 600;

  protected static $levels = [
    self::DEBUG => [
      'name' => 'DEBUG',
      'formatted' => '\e[0;30;45m [DEBUG]\e[0m'
    ],
    self::INFO => [
      'name' => 'INFO',
      'formatted' => '\e[0;30;46 [INFO]\e[0m'
    ],
    self::NOTICE => [
      'name' => 'NOTICE',
      'formatted' => '\e[0;30;44 [NOTICE]\e[0m'
    ],
    self::WARNING => [
      'name' => 'WARNING',
      'formatted' => '\e[0;30;43 [WARNING]\e[0m'
    ],
    self::ERROR => [
      'name' => 'ERROR',
      'formatted' => '\e[0;30;41 [ERROR]\e[0m'
    ],
    self::CRITICAL => [
      'name' => 'CRITICAL',
      'formatted' => '\e[1;37;40 [CRITICAL]\e[0m'
    ],
    self::ALERT => [
      'name' => 'ALERT',
      'formatted' => '\e[0;30;43 [ALERT]\e[0m'
    ],
    self::EMERGENCY => [
      'name' => 'EMERGENCY',
      'formatted' => '\e[0;30;43 [EMERGENCY]\e[0m'
    ]
  ];
  
  public static function getLevels(): array
  {
    return static::$levels;
  }

  public static function getLevelName(int $levelNumber): string
  {
    if(!isset(static::$levels[$levelNumber])) {
      $this->handleError($levelNumber);
    }
    return static::$levels[$levelNumber]['name'];
  }

  public static function getLevelColor(int $levelNumber): string
  {
    if(!isset(static::$levels[$levelNumber])) {
      $this->handleError($levelNumber);
    }
    return static::$levels[$levelNumber]['formatted'];
  }

  private function handleError(int $levelNumber): InvalidArgumentException {
    throw new InvalidArgumentException(
      "Level $levelNumber is not defined in none of these levels: "
      . implode(', ', static::$levels)
    );
  }
  public function debug($message, array $context = []): string
  {
    return $this->mountMessage(self::DEBUG, (string) $message);
  }

  public function info($message, array $context = array())
  {
    return $this->mountMessage(self::INFO, (string) $message);
  }

  public function notice($message, array $context = array())
  {
    return $this->mountMessage(self::NOTICE, (string) $message);
  }

  public function warning($message, array $context = array())
  {
    return $this->mountMessage(self::NOTICE, (string) $message);
  }

  public function error($message, array $context = array())
  {
    return $this->mountMessage(self::ERROR, (string) $message);
  }

  public function critical($message, array $context = array())
  {
    return $this->mountMessage(self::CRITICAL, (string) $message); 
  }

  public function alert($message, array $context = array())
  {
    return $this->mountMessage(self::CRITICAL, (string) $message); 
  }

  public function emergency($message, array $context = array())
  {
    return $this->mountMessage(self::EMERGENCY, (string) $message); 
  }

  public function log($level, $message, array $context = array())
  {
    return $this->mountMessage($level, (string) $message); 
  }

  private function mountMessage(int $level, $message, array $context = []): string {
    $replace = [];
    foreach($context as $key => $value) {
      if(!is_array($value) && (!is_object($value) || method_exists($value, '__toString'))) {
        $replace['{'.$key.'}'] = $value;
      }
    }
    $msg = strtr($message, $replace);
    $string = Timer::exec() . self::getLevelColor($level) . ' ' . $msg;

    return $string;
  }
}
