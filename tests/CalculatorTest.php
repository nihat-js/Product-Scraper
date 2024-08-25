<?php
use PHPUnit\Framework\TestCase;

require '../vendor/autoload.php';

class CalculatorTest extends TestCase
{

  private Calculator $calculator;

  public function __construct()
  {
    $calculator = new \App\Calculator();
  }
  public function testAddition()
  {

    $result = $this->calculator->sum(2, 2);
    $this->assertEquals(4, $result);
  }

  public function testSubtract()
  {
    $result = $this->calculator->subtract(5, 2);
    $this->assertEquals(3, $result);
  }

}
