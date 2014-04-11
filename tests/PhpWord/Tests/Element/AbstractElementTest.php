<?php
/**
 * PHPWord
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2014 PHPWord
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 */

namespace PhpOffice\PhpWord\Tests\Element;

/**
 * Test class for PhpOffice\PhpWord\Element\Cell
 *
 * @runTestsInSeparateProcesses
 */
class AbstractElementTest extends \PHPUnit_Framework_TestCase
{
    public function testElementIndex(){
      $stub = $this->getMockForAbstractClass('\PhpOffice\PhpWord\Element\AbstractElement');
      $ival = rand(0, 100);
      $stub->setElementIndex($ival);
      $this->assertEquals($stub->getElementIndex(), $ival);
    }
    public function testElementId(){
      $stub = $this->getMockForAbstractClass('\PhpOffice\PhpWord\Element\AbstractElement');
      $stub->setElementId();
      $this->assertEquals(strlen($stub->getElementId()), 6);
    }
}