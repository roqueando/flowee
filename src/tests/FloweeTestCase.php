<?php

namespace Flowee\Tests;

use PHPUnit\Framework\TestCase;
use Flowee\Core\Application;
class FloweeTestCase extends TestCase {
	protected $managerPid;

	public function setUp(): void {
		parent::setUp();
	}	

	public function tearDown(): void {
		$this->stopServer();
	}
	
  protected function shouldSeeManagerOutput($content) {
    $this->assertContains($content, file_get_contents('src/tests/.output/manager.log'), "Couldn't find '$content' in manager.log");
  }
	public function stopServer() {
    file_put_contents('src/tests/.output/manager.log', '');
		exec("kill {$this->managerPid} > /dev/null 2>&1");
	}

	protected function runServer(){
		$this->managerPid = exec(
						'php flowee.php > src/tests/.output/manager.log 2>&1 & echo $!',
			$output					
    );
    sleep(1);
	}
}
