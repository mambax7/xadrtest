<?php
namespace Xmf\Xadr\Validator;

require_once(dirname(__FILE__).'/../../../../init_mini.php');

/**
 * PHPUnit special settings :
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class StringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var String
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $context = \Xmf\Xadr\Controller::getNew();
        $this->object = new String($context);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers Xmf\Xadr\Validator\String::execute
     * @covers Xmf\Xadr\Validator\String::initialize
     */
    public function testExecute()
    {
        $range_lo_alpha = range('a', 'z');
        $range_hi_alpha = range('A', 'Z');
        $range_numeric  = range('0', '9');
        $range = array_merge($range_lo_alpha, $range_hi_alpha, $range_numeric);

        $params = array(
            'allowed'     => true,
            'chars'       => $range,
            'max'         => -1,
            'min'         => -1,
            'trim'        => true,
        );
        $this->object->initialize($params);

        $input = ' Something ';
        $expected = 'Something';
        $valid = $this->object->execute($input);
        $this->assertTrue($valid, $this->object->getErrorMessage());
        $this->assertEquals($input, $expected);

        $input = ' {Something} ';
        $expected = '{Something}';
        $valid = $this->object->execute($input);
        $this->assertFalse($valid, $this->object->getErrorMessage());
        $this->assertEquals($input, $expected);

        $params = array(
            'allowed'     => false,
            'chars'       => $range,
            'max'         => -1,
            'min'         => -1,
            'trim'        => true,
        );
        $this->object->initialize($params);

        $input = 'Something';
        $expected = 'Something';
        $valid = $this->object->execute($input);
        $this->assertFalse($valid, $this->object->getErrorMessage());
        $this->assertEquals($input, $expected);

        $params = array(
            'allowed'     => true,
            'chars'       => array(),
            'max'         => 6,
            'min'         => 5,
            'trim'        => false,
            'max_error'   => 'long',
            'min_error'   => 'short',
        );
        $this->object->initialize($params);
        $input = ' 12345 ';
        $valid = $this->object->execute($input);
        $this->assertFalse($valid, $this->object->getErrorMessage());
        $this->assertEquals($this->object->getErrorMessage(), 'long');

        $input = '1234';
        $valid = $this->object->execute($input);
        $this->assertFalse($valid, $this->object->getErrorMessage());
        $this->assertEquals($this->object->getErrorMessage(), 'short');

        $params = array(
            'allowed'     => true,
            'chars'       => array('私', 'の', '団', '体', 'も'),
            'max'         => 5,
            'min'         => 5,
            'trim'        => true,
            'max_error'   => 'long',
            'min_error'   => 'short',
        );
        $this->object->initialize($params);
        $input = ' 私の団体も ';
        $valid = $this->object->execute($input);
        $this->assertTrue($valid, $this->object->getErrorMessage());
        $this->assertSame($input, '私の団体も');

    }

    /**
     * @covers Xmf\Xadr\Validator\String::getDefaultParams
     */
    public function testGetDefaultParams()
    {
        $parms = $this->object->getDefaultParams();
        $this->assertTrue(is_array($parms));
    }
}
