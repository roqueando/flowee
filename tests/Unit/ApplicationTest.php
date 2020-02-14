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
    $this->assertNotEmpty($server_log);
  }

  /** @test **/
  public function should_receive_data() {
    $this->runServer();
    $data = $this->prepareData('error');

    $socket = stream_socket_client('tcp://127.0.0.1:8000');
    stream_socket_sendto($socket, json_encode($data));

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
  public function should_not_save_logs_in_root() {
    $this->runServer();
    $data = $this->prepareData('error');
    $this->createSocketAndSendData($data);

    sleep(1);
    $files = glob("src/log/*.log");
    $this->assertEquals(0, count($files));
  }

  /** @test **/
  public function should_save_logs_in_respectively_folders() {
    $this->runServer();

    $data = $this->getAllData();
    foreach($data as $d => $value) {
      $this->createSocketAndSendData($value);
    }

    sleep(1);
    
    foreach($data as $log => $content) {
      $this->assertDirectoryExists("src/log/$log");
      $files = glob("src/log/$log/*.log");
      $this->assertGreaterThan(0, $files);

      $filename = $files[0];
      $this->assertFileExists("$filename");
      $fileContent = file_get_contents("$filename");
      $this->assertStringContainsString($content->message, $fileContent);
      $this->cleanLogs($log);
    }
  }

  private function getAllData(): array {
    return [
      'errors' => $this->prepareData('error', true),
      'warnings' => $this->prepareData('warning', true),
      'successes' => $this->prepareData('success', true),
      'faileds' => $this->prepareData('fail', true)
    ];
  }

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
