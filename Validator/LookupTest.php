<?php
namespace Xmf\Xadr\Validator;

require_once(dirname(__FILE__).'/../../../../init_mini.php');

/**
 * PHPUnit special settings :
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class LookupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Lookup
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $context = \Xmf\Xadr\Controller::getNew();
        $this->object = new Lookup($context);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Xmf\Xadr\Validator\Lookup::execute
     * @covers Xmf\Xadr\Validator\Lookup::initialize
     */
    public function testExecute()
    {
        $params = array(
            'lookup_column' => 'uid',
            'lookup_table'  => 'users',
        );
        $this->object->initialize($params);

        $lookup = 1;
        $valid = $this->object->execute($lookup);
        $this->assertTrue($valid, $this->object->getErrorMessage());

        $lookup = -1024;
        $valid = $this->object->execute($lookup);
        $this->assertFalse($valid, $this->object->getErrorMessage());

    }

    /**
     * @covers Xmf\Xadr\Validator\Lookup::getDefaultParams
     */
    public function testGetDefaultParams()
    {
        $parms = $this->object->getDefaultParams();
        $this->assertTrue(is_array($parms));
    }
}
