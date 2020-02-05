<?php

namespace Flowee\Core;

use Exception;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\ConnectionInterface;
use Flowee\Core\Data;
use Flowee\Core\Timer;

class Application
{

  protected $stream;
  protected $clients = [];
	protected $running;
	public static $server;
	public static $instance;

  public function __construct()
  {
    set_time_limit(0);
		ob_implicit_flush();
    $this->logo();
  }
	
	public static function getInstance() {
		if(self::$instance === null) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function getServerInstance() {
		return self::$server;
	}

	private function setInstance(Server $server) {
		self::$server = $server;
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
    $loop = Factory::create();

    $server = new Server("$host:$port", $loop);
		
		$this->setInstance($server);
    $server->on('connection', function (ConnectionInterface $socket) {
      echo Timer::exec() . "a connection was estabilished (".$socket->getRemoteAddress().")\n";

      $socket->on('data', function($data) use ($socket) {
        // always that a data comes
				// will create a new Data instance and manipulate that returning the exactly log.	
        (new Data($data))->log();
      });
    });
		
    $loop->run();
  }

  private function error($socket): Exception
  {
    $timer = date('H:i:s');
    $last_error = socket_strerror(socket_last_error($socket));
    $message = "[$timer]: $last_error";
    throw new Exception($message);
  }

  private function logo(): void
  {
    echo '
              ▛▀▘▜              
              ▙▄ ▐ ▞▀▖▌  ▌▞▀▖▞▀▖
              ▌  ▐ ▌ ▌▐▐▐ ▛▀ ▛▀ 
              ▘   ▘▝▀  ▘▘ ▝▀▘▝▀▘
    A simple logger server that can connect with all other services.
    Built in PHP by Vitor Roque - 2020 - @roqueando.
    ';
	}

	public function close(): void {
		$this->server->close();
	}
}
