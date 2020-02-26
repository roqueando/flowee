<?php
namespace Tests\Unit;
use Tests\FloweeTestCase;
use Flowee\Core\Logger;

class LoggerTest extends FloweeTestCase {
  
  /** @test **/
  public function should_return_correctly_log() {
    $logger = new Logger();
    $levels = $logger->getLevels();
    
    foreach($levels as $key => $value) {
      if(method_exists($logger, strtolower($value['name']))) {
        $methodName = strtolower($value['name']);

        $string = $logger->{$methodName}("Testing");
        $this->assertStringContainsString("Testing", $string);
      }
    }
  }
}
