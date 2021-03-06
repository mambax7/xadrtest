<?php
namespace Xmf\Xadr\Validator;

require_once(dirname(__FILE__).'/../../../../init_mini.php');

/**
 * PHPUnit special settings :
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class EmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Email
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $context = \Xmf\Xadr\Controller::getNew();
        $this->object = new Email($context);
        $this->object->initialize(array());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Xmf\Xadr\Validator\Email::execute
     */
    public function testExecute()
    {
        $email = ' user@example.com ';
        $valid = $this->object->execute($email);
        $this->assertTrue($valid, $this->object->getErrorMessage());
        $this->assertEquals($email, 'user@example.com', $this->object->getErrorMessage());


        $email = 'userXexample.com';
        $valid = $this->object->execute($email);
        $this->assertFalse($valid, $this->object->getErrorMessage());
    }

    /**
     * @covers Xmf\Xadr\Validator\Email::initialize
     */
    public function testInitialize()
    {
        $params = array(
            'email_error' => 'invalid',
            'max' => 30,
            'max_error' => 'long',
            'min' => 8,
            'min_error' => 'short',
        );

        $this->object->initialize($params);

        $email = '12345678901234567890123456789';
        $valid = $this->object->execute($email);
        $this->assertFalse($valid);
        $this->assertEquals($this->object->getErrorMessage(), 'invalid');

        $email = 'x12345678901234567890123456789@example.com';
        $valid = $this->object->execute($email);
        $this->assertFalse($valid);
        $this->assertEquals($this->object->getErrorMessage(), 'long');

        $email = 'j@o.co';
        $valid = $this->object->execute($email);
        $this->assertFalse($valid);
        $this->assertEquals($this->object->getErrorMessage(), 'short');

    }

    /**
     * @covers Xmf\Xadr\Validator\Email::getDefaultParams
     */
    public function testGetDefaultParams()
    {
        $parms = $this->object->getDefaultParams();
        $this->assertTrue(is_array($parms));
    }
}
