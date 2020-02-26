<?php

namespace Flowee\Core;

use Exception;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\ConnectionInterface;
use Flowee\Core\Data;
use Flowee\Core\Timer;
use Flowee\Core\Logger;

/**
 * Manage the entire application
 * @author Vitor Roque
 */
class Application
{

  protected $logger;
	public static $instance;

  public function __construct()
  {
    set_time_limit(0);
		ob_implicit_flush();
    $this->logger = new Logger;
    $this->logo();
  }
	
	public static function getInstance() {
		if(self::$instance === null) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/** 
	 * Run the flowee server instance
	 *
	 * @param string $host
	 * @param int $port 
	 * @return void
	 *
	 * **/
  public function run(string $host = '127.0.0.1', int $port = 8000): void
  {
    try {
      $loop = Factory::create();

      $server = new Server("$host:$port", $loop);
		
      $server->on('connection', function (ConnectionInterface $socket) {
        echo Timer::exec() . "a connection was estabilished (".$socket->getRemoteAddress().")\n";

        $socket->on('data', function($data) {
          // always that a data comes
          // will create a new Data instance and manipulate that returning the exactly log.	
          (new Data($data, $this->logger))->handle();
        });
      });
		
      $loop->run();

    } catch(Exception $err) {
      $errorMessage = "[{$err->getCode}]: {$err->getMessage()} on line {$err->getLine()}";
      echo $this->logger->critical($errorMessage);
    }
  }

  /**
   * Prints logo into console
   * @return void
   */
  private function logo(): void
  {
    echo '
              ▛▀▘▜              
              ▙▄ ▐ ▞▀▖▌  ▌▞▀▖▞▀▖
              ▌  ▐ ▌ ▌▐▐▐ ▛▀ ▛▀ 
              ▘   ▘▝▀  ▘▘ ▝▀▘▝▀▘
    A simple logger server that can connect with all other services.
    Built in PHP by Vitor Roque - 2020 - @roqueando.
    CTRL + C to stop server.
    ';
	}

}
