<?php

namespace Flowee\Core;
use Flowee\Core\Timer;
use Psr\Log\LoggerInterface;

/**
 * Mounts and handle logs and .log files
 * @author Vítor Roque
 */
class Data {

  /**
   * @var object $data
   */
	protected $data;

  /**
   * @var boolean $logFile
   */
	protected $logFile = false;

  /**
   * @var LoggerInterface $logger
   */
  protected $logger;

  public function __construct($data, LoggerInterface $logger = null)
  {
    $this->data = $data;
    $this->logger = $logger;
  }

  /**
   * Handle all logging process
   * @return void
   */
  public function handle(): void {
    if($this->checkDefault($this->data)) {
      $this->setData();

      $type = strtolower($this->data->type);
      if(method_exists($this->logger, $type)) {
        $log = $this->logger->{$type}($this->data->message);
        $this->saveLog(strtoupper($type), $log);
        echo $log; 
      } 
    }
  }

  /**
   * Save log into a .log file if wants
   * @param string $type
   * @param string $message
   * @return void
   */
  private function saveLog(string $type, $message): void {
    // save log file here
    if($this->logFile) {
      $filename = $type . "_" . Timer::fileTime();
      $filepath = dirname(dirname(__FILE__)) . '/log/';
      file_put_contents("{$filepath}/{$filename}.log", $message);
    }
  }

  /**
   * Data setter
   * @return void
   */
  public function setData(): void {
    $this->data = json_decode($this->data);
  }

  /**
   * Check the default structure to receive data from clients
   * @param string $data
   * @return boolean
   */
  private function checkDefault(string $data): bool {
    if($this->is_json($data)) {
			$data = json_decode($data);
			if(isset($data->save)) {
				$this->logFile = $data->save;
			}
      if(isset($data->type) && isset($data->message)) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  /**
   * Check if given string is JSON
   * @param string $data 
   * @return boolean
   */
  private function is_json(string $data): bool {
    json_decode($data);
    return (json_last_error() == JSON_ERROR_NONE);
  }
}
