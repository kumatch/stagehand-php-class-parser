<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5
 *
 * Copyright (c) 2009 KUMAKURA Yousuke <kumatch@gmail.com>,
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_PHP_Class_Parser_InterfaceTest

/**
 * Some tests for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_Parser_InterfaceTest extends PHPUnit_Framework_TestCase
{

    // {{{ properties

    /**#@+
     * @access public
     */

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    private $_filename;

    /**#@-*/

    /**#@+
     * @access public
     */

    public function setUp() { }

    public function tearDown() { }

    /**
     * @test
     */
    public function parseAnInterface()
    {
        $class = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__) . '/InterfaceTest/Foo.php');

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_InterfaceTest_Foo');
        $this->assertFalse($class->isAbstract());
        $this->assertTrue($class->isInterface());
        $this->assertEquals($class->getDocComment(),"/**
 * A test class for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */");

        $constants = $class->getConstants();

        $this->assertEquals(count($constants), 2);

        $this->assertEquals($constants['A']->getValue(), 10);
        $this->assertNull($constants['B']->getValue());

        $properties = $class->getProperties();

        $this->assertEquals(count($properties), 0);

        $methods = $class->getMethods();

        $this->assertEquals(count($methods), 2);

        $this->assertTrue($methods['doMethodA']->isPublic());
        $this->assertFalse($methods['doMethodA']->isStatic());
        $this->assertFalse($methods['doMethodA']->isFinal());
        $this->assertNull($methods['doMethodA']->getCode());
        $this->assertEquals($methods['doMethodA']->getDocComment(), "/**
     * doMethodA()
     */");
        $this->assertEquals(count($methods['doMethodA']->getArguments()), 0);

        $this->assertTrue($methods['doMethodB']->isPublic());
        $this->assertFalse($methods['doMethodB']->isStatic());
        $this->assertFalse($methods['doMethodB']->isFinal());
        $this->assertNull($methods['doMethodB']->getCode());
        $this->assertNull($methods['doMethodB']->getDocComment());

        $doMethodBArguments = $methods['doMethodB']->getArguments();

        $this->assertEquals(count($doMethodBArguments), 2);
        $this->assertNull($doMethodBArguments['foo']->getValue());
        $this->assertTrue($doMethodBArguments['foo']->isRequired());
        $this->assertEquals($doMethodBArguments['bar']->getValue(), 100);
        $this->assertFalse($doMethodBArguments['bar']->isRequired());
    }

    /**
     * @test
     */
    public function parseAnInterfaceWithSetInterfaces()
    {
        $class = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__) .
                                               '/InterfaceTest/HasOneInterface.php'
                                               );

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_InterfaceTest_HasOneInterface');
        $this->assertTrue($class->isInterface());

        $interfaces = $class->getInterfaces();

        $this->assertEquals(count($interfaces), 1);
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceOne'],
                            'Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceOne'
                            );

        $class = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__) .
                                               '/InterfaceTest/HasThreeInterfaces.php'
                                               );

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_InterfaceTest_HasThreeInterface');

        $interfaces = $class->getInterfaces();

        $this->assertEquals(count($interfaces), 3);
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceOne'],
                            'Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceOne'
                            );
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceTwo'],
                            'Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceTwo'
                            );
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceThree'],
                            'Stagehand_PHP_Class_Parser_InterfaceTest_InterfaceThree'
                            );
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    /**#@-*/

    // }}}
}

// }}}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
