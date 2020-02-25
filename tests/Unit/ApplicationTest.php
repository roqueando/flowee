<?php
namespace Tests\Unit;
use Tests\FloweeTestCase;

class ApplicationTest extends FloweeTestCase {
	
	public function setUp(): void
  {
    // parent set up for our testCase
    parent::setUp();
  }
  
  /** @test **/
  public function should_init_server() {
    $this->runServer();
    $server_log = file_get_contents('tests/.output/manager.log');

    // check if the logo and server was initiated
    $this->assertNotEmpty($server_log);
  }

  /** @test **/
  public function should_receive_data() {
    $this->runServer();
    $data = $this->prepareData('error');

    $this->createSocketAndSendData($data);

    sleep(1);
    $log = file_get_contents('tests/.output/manager.log');
    $this->assertStringContainsString($data->message, $log);
    $this->cleanLogs();
  }

  /** @test **/
  public function should_check_data_correctly(){
    $this->assertJson(json_encode($this->prepareData('error')));
  }
  
  /** @test **/
  public function should_save_on_right_moment() {
    $this->runServer();

    // Prepare data object for error and debug
    // error will not save
    // debug will save a log file
    $dataError = $this->prepareData('error');
    $dataDebug = $this->prepareData('debug', true);

    // Creating a socket and sending to flowee
    $this->createSocketAndSendData($dataError);
    $this->createSocketAndSendData($dataDebug);
    
    sleep(1);

    // declare the data type logs
    $dataTypeError = strtoupper($dataError->type);
    $dataTypeDebug = strtoupper($dataDebug->type);
    
    // searching for debug type logs
    $filesDebug = glob("src/log/{$dataTypeDebug}_*.log");
    $filesError = glob("src/log/{$dataTypeError}_*.log");
    
    $this->assertGreaterThan(0, count($filesDebug));
    $this->assertEquals(0, count($filesError));
    $this->cleanLogs();
  }
  /**
   * Create a socket stream client and send a socket message
   * @param object $data
   * @return void
   */
  private function createSocketAndSendData(object $data): void {
    $socket = stream_socket_client('tcp://127.0.0.1:8000');
    stream_socket_sendto($socket, json_encode($data));
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
