<?php

namespace Flowee\Tests;

use PHPUnit\Framework\TestCase;
use Flowee\Core\Application;
class FloweeTestCase extends TestCase {
	protected $managerPid;

	public function setUp(): void {
		parent::setUp();
		$this->runServer();
	}	

	public function tearDown(): void {
		$this->stopServer();
	}
	
	public function stopServer() {
		exec("kill {$this->managerPid} > /dev/null 2>&1");
	}

	protected function runServer(){
		$this->managerPid = exec(
						'php flowee.php > src/tests/.output/manager.log 2>&1 & echo $!',
			$output					
		);
	}
}
