<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';
require_once 'BaseLogParserTestCase.php';

class unit_LogParserTest extends BaseLogParserTestCase {
  /**
  * @expectedException LogFileNotFoundException
  */
  public function testGetNotExistingLogFile() {	
    $this->logParser->getRawLogFile($this->LFIXDIR."asodijfsfj.log");
  }
  
  public function testGetExistingLogFile() {	
    $this->assertNotEmpty($this->logParser->getRawLogFile($this->LFIXDIR."blah.log"));
  }
  
  //the last line of the log file is usually truncated, and corrupt. Ignore exceptions for that line.
  public function testIgnoreUnrecognizedExceptionOnLastLine() {
    $this->logParser->parseLogFile($this->LFIXDIR."mini_truncated.log", 1);
  }
  
  //the last line of the log file is usually truncated, and corrupt. Ignore exceptions for that line.
  public function testIgnoreCorruptExceptionOnLastLine() {
    $this->logParser->parseLogFile($this->LFIXDIR."mini_truncated_corrupt.log", 1);
  }
  
  public function testParseFromDB() {
    $log = $this->logParser->parseLogFile($this->LFIXDIR."mini.log", 1);
    $this->logParser = new LogParser();
    $log = $this->logParser->parseLogFromDB($log);
    
    $this->assertEquals(8, count($log->getStats()), "number of players, should exclude console and specs");
  }
}
