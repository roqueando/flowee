<?php

namespace Flowee\Core;
use Flowee\Core\Timer;

class Data {

	protected $data;
	protected $logFile = false;

  public function __construct($data)
  {
    $this->data = $data;
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
    $folder = '';
		switch($dataType) {
			case 'error':
				$colorNumber = '31';
        $folder = 'errors';
				break;
			case 'warning':
				$colorNumber = '33';
        $folder = 'warnings';
				break;
			case 'success':
				$colorNumber = '92';
        $folder = 'successes';
				break;
			case 'fail':
				$colorNumber = '35';
        $folder = 'faileds';
				break;
			default:
				$colorNumber = '39';
				break;
		}
		
		$message = Timer::exec() . "\e[{$colorNumber}m [$dataType] \e[39m" . $this->data->message;
		echo $message;
		if($this->logFile) {
			$filename = Timer::fileTime();
			$filepath =  dirname(dirname(__FILE__)) . '/log/'. $folder;
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
				$this->logFile = true;
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
