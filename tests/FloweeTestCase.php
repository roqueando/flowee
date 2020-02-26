<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class FloweeTestCase extends TestCase {
	protected $managerPid;
  public static $testOutput;

  public function tearDown(): void {
		$this->stopServer();
	}
	
  protected function cleanLogs(string $folder = ''): void {
    if($_ENV['APP_ENV'] === 'testing') {
      $files = glob('src/log/*.log');
      if(isset($folder) && !empty($folder)) {
        $files = glob("src/log/$folder/*.log");
      }
      foreach($files as $file) {
        if(is_file($file)) {
          unlink($file);
        }
      }
    }
  }
  protected function shouldSeeManagerOutput($content) {
    $this->assertContains(
      $content, 
      file_get_contents('tests/.output/manager.log'), 
      "Couldn't find '$content' in manager.log"
    );
  }
	public function stopServer() {
    file_put_contents('tests/.output/manager.log', '');
		exec("kill {$this->managerPid} > /dev/null 2>&1");
	}

	protected function runServer(){
		$this->managerPid = exec(
						'php flowee.php > tests/.output/manager.log 2>&1 & echo $!',
			$output					
    );
    sleep(1);
	}

}
