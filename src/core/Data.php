<?php

namespace Flowee\Core;
use Flowee\Core\Timer;
use Psr\Log\LoggerInterface;

class Data {

	protected $data;
	protected $logFile = false;
  protected $logger;

  public function __construct($data, LoggerInterface $logger = null)
  {
    $this->data = $data;
    $this->logger = $logger;
  }

  public function log() {
    if($this->checkDefault($this->data)) {
      $this->setData();
			$this->handleError($this->data->type);
    }
    return;
  }

	private function handleError($dataType) {
		$type = strtoupper($dataType);
		$colorNumber = '39';

		switch($dataType) {
			case 'error':
				$colorNumber = '31';
				break;
			case 'warning':
				$colorNumber = '33';
				break;
			case 'success':
				$colorNumber = '92';
				break;
			case 'fail':
				$colorNumber = '35';
				break;
			default:
				$colorNumber = '39';
				break;
		}
		
		$message = Timer::exec() . "\e[{$colorNumber}m [$dataType] \e[39m" . $this->data->message;
		echo $message;
		if($this->logFile) {
			$filename = $type ."_". Timer::fileTime();
			$filepath =  dirname(dirname(__FILE__)) . '/log/';
			file_put_contents("{$filepath}/{$filename}.log", $message);
		}
  }

  public function setData() {
    $this->data = json_decode($this->data);
  }

  private function checkDefault($data): bool {
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
  private function is_json(string $data): bool {
    json_decode($data);
    return (json_last_error() == JSON_ERROR_NONE);
  }
}
