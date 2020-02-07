<?php
namespace Flowee\Tests;

use Exception;
use Flowee\Core\Application;
use Flowee\Tests\FloweeTestCase;
use React\Socket\Connector;
use React\Socket\ConnectionInterface;
use React\EventLoop\Factory;

class ApplicationTest extends FloweeTestCase {
	
	public function setUp(): void
  {
    // parent set up for our testCase
    parent::setUp();
  }
  
  /** @test **/
  public function should_init_server() {
    $this->runServer();
    $server_log = file_get_contents('src/tests/.output/manager.log');
    $this->assertNotEmpty($server_log);
  }
  /** @test **/
  public function should_receive_data() {
    $this->runServer();
    $data = $this->prepareData('error');

    $socket = stream_socket_client('tcp://127.0.0.1:8000');
    stream_socket_sendto($socket, json_encode($data));

    sleep(1);
    $log = file_get_contents('src/tests/.output/manager.log');
    $this->assertStringContainsString($data->message, $log);
  }

  /** @test **/
  public function should_check_data_correctly(){
    $this->assertJson(json_encode($this->prepareData('error')));
  }
  
  /**
   * Preparing a object data
   * @param String $type
   * @param String $saving
   * @return object
   * **/
  private function prepareData(string $type, bool $saving = false): object {
    $arr = (object) [
      'type' => $type,
      'save' => $saving,
      'message' => "default error with type $type ."
    ];

    return $arr;
  }
}
