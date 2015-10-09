<?php

namespace Soluble\Japha\Bridge;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class PhpJavaBridgeTest extends \PHPUnit_Framework_TestCase
{
    protected $pjb;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        \SolubleTestFactories::startJavaBridgeServer();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     *
     */
    public function testIncludeBridge()
    {
        PhpJavaBridge::includeBridge(\SolubleTestFactories::getJavaBridgeServerAddress());
    }
    
    public function testJavaClass()
    {
        $system = PhpJavaBridge::getJavaClass('java.lang.System');
        
        $this->assertInstanceOf("\Soluble\Japha\Interfaces\JavaClass", $system);
        $this->assertInstanceOf("\Soluble\Japha\Interfaces\JavaObject", $system);
        $properties = $system->getProperties();
        $this->assertInstanceOf("\Soluble\Japha\Interfaces\JavaObject", $properties);
        
        
        $this->assertEquals("java.util.Properties", $properties->get__signature());
        $this->assertEquals("java.util.Properties", $properties->getClass()->getName());
        $this->assertInstanceOf("\Soluble\Japha\Interfaces\JavaObject", $properties->getClass());
    }

    public function testDriverPjb621()
    {
        $pjb = PhpJavaBridge::getDriver();

        $system = $pjb->getJavaClass('java.lang.System');
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\JavaClass', $system);
        $this->assertEquals('java.lang.System', $system->get__signature());

        /* @var $properties \Soluble\Japha\Bridge\Pjb621\InternalJava */
        $properties = $system->getProperties();
//var_dump(get_class($properties));
//die();
      //  $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\InternalJava', $properties);
        $this->assertEquals("java.util.Properties", $properties->get__signature());

        $this->assertInternalType('string', $properties->__cast('string'));
        $this->assertInternalType('string', $properties->__toString());

        foreach ($properties as $key => $value) {
            $this->assertInternalType('string', $key);
            $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\InternalJava', $value);
        }

        $iterator = $properties->getIterator();
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\ObjectIterator', $iterator);
        $this->assertInstanceOf('Iterator', $iterator);


        $vm_name = $properties->get('java.vm.name');
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\InternalJava', $vm_name);
        
        // whether Java, OpenJDK..., 'J' is wide
        $this->assertContains('J', $vm_name->__toString());
        $this->assertContains('J', (string) $vm_name);


        $i1 = new Driver\Pjb621\Java("java.math.BigInteger", 1);
        $i2 = new Driver\Pjb621\Java("java.math.BigInteger", 2);
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\Java', $i2);

        $i3 = $i1->add($i2);
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\InternalJava', $i3);
        $this->assertTrue(Driver\Pjb621\java_instanceof($i1, $pjb->getJavaClass('java.math.BigInteger')));
        $this->assertEquals('3', $i3->toString());


        $params = $pjb->instanciate("java.util.HashMap");
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb621\Java', $params);
        $this->assertEquals('java.util.HashMap', $params->get__signature());


        $util = $pjb->getJavaClass("php.java.bridge.Util");

        $ctx = Driver\Pjb621\java_context();
        /* get the current instance of the JavaBridge, ServletConfig and Context */
        $bridge = $ctx->getAttribute("php.java.bridge.JavaBridge", 100);
        $config = $ctx->getAttribute("php.java.servlet.ServletConfig", 100);
        $context = $ctx->getAttribute("php.java.servlet.ServletContext", 100);
        $servlet = $ctx->getAttribute("php.java.servlet.Servlet", 100);

        $inspected = Driver\Pjb621\java_inspect($bridge);
        $this->assertInternalType('string', $inspected);
        $this->assertContains('php.java.bridge.JavaBridge.getCachedString', $inspected);
    }
}
