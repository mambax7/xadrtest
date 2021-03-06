<?php
namespace Xmf\Xadr\Validator;

require_once(dirname(__FILE__).'/../../../../init_mini.php');

/**
 * PHPUnit special settings :
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class StripTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Strip
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $context = \Xmf\Xadr\Controller::getNew();
        $this->object = new Strip($context);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Xmf\Xadr\Validator\Strip::execute
     * @covers Xmf\Xadr\Validator\Strip::initialize
     */
    public function testExecute()
    {
        $params = array(
            'chars' => array('X','x'),
        );
        $this->object->initialize($params);

        $input = 'XsxoxmxxxxetXhingx';
        $expected = 'something';
        $valid = $this->object->execute($input);
        $this->assertTrue($valid, $this->object->getErrorMessage());
        $this->assertEquals($input, $expected);

        $input = 'nothing to remove';
        $expected = 'nothing to remove';
        $valid = $this->object->execute($input);
        $this->assertTrue($valid, $this->object->getErrorMessage());
        $this->assertEquals($input, $expected);

        $params = array(
            'chars' => array('司','公'),
        );
        $this->object->initialize($params);

        $input = '中国化工集团公司.公司';
        $expected = '中国化工集团.';
        $valid = $this->object->execute($input);
        $this->assertTrue($valid, $this->object->getErrorMessage());
        $this->assertEquals($input, $expected);
    }

    /**
     * @covers Xmf\Xadr\Validator\Strip::getDefaultParams
     */
    public function testGetDefaultParams()
    {
        $parms = $this->object->getDefaultParams();
        $this->assertTrue(is_array($parms));
    }
}
