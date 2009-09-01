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

// {{{ Stagehand_PHP_Class_Parser_AbstractTest

/**
 * Some tests for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_Parser_AbstractTest extends PHPUnit_Framework_TestCase
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

    public function setUp()
    {
        $this->_basic = dirname(__FILE__) . '/AbstractTest/Foo.php';
        $this->_extended = dirname(__FILE__) . '/AbstractTest/Bar.php';
    }

    public function tearDown() { }

    /**
     * @test
     */
    public function parseAnAbstract()
    {
        $class = Stagehand_PHP_Class_Parser::parse($this->_basic);

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_AbstractTest_Foo');
        $this->assertTrue($class->isAbstract());
        $this->assertFalse($class->isInterface());
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

        $this->assertEquals(count($constants), 1);
        $this->assertEquals($constants['number']->getValue(), 10);


        $properties = $class->getProperties();

        $this->assertEquals(count($properties), 5);

        $this->assertNull($properties['foo']->getValue());
        $this->assertEquals($properties['bar']->getValue(), 100);
        $this->assertEquals($properties['baz']->getValue(), 'BAZ');

        $this->assertTrue($properties['foo']->isPublic());
        $this->assertTrue($properties['bar']->isPublic());
        $this->assertTrue($properties['bar']->isStatic());
        $this->assertTrue($properties['baz']->isPublic());
        $this->assertTrue($properties['_bar']->isProtected());
        $this->assertTrue($properties['_baz']->isPrivate());

        $this->assertEquals($properties['foo']->getDocComment(), "/**
     * public foo
     */");
        $this->assertEquals($properties['bar']->getDocComment(), "/**
     * public static bar
     */");
        $this->assertEquals($properties['baz']->getDocComment(), "/**
     * var baz
     */");
        $this->assertNull($properties['_bar']->getDocComment());
        $this->assertNull($properties['_baz']->getDocComment());


        $methods = $class->getMethods();

        $this->assertEquals(count($methods), 7);

        $this->assertFalse($methods['__construct']->isAbstract());
        $this->assertTrue($methods['__construct']->isPublic());
        $this->assertFalse($methods['__construct']->isStatic());
        $this->assertFalse($methods['__construct']->isFinal());
        $this->assertFalse($methods['__construct']->isReference());
        $this->assertNull($methods['__construct']->getCode());
        $this->assertEquals($methods['__construct']->getDocComment(), "/**
     * __construct()
     */");
        $this->assertEquals(count($methods['__construct']->getArguments()), 0);

        $this->assertFalse($methods['staticMethod']->isAbstract());
        $this->assertTrue($methods['staticMethod']->isPublic());
        $this->assertTrue($methods['staticMethod']->isStatic());
        $this->assertFalse($methods['staticMethod']->isFinal());

        $this->assertFalse($methods['finalMethod']->isAbstract());
        $this->assertTrue($methods['finalMethod']->isPublic());
        $this->assertFalse($methods['finalMethod']->isStatic());
        $this->assertTrue($methods['finalMethod']->isFinal());
        $this->assertEquals($methods['finalMethod']->getDocComment() ,"/**
     * finalMethod()
     */");

        $this->assertFalse($methods['protectedMethod']->isAbstract());
        $this->assertTrue($methods['protectedMethod']->isProtected());
        $this->assertFalse($methods['protectedMethod']->isStatic());
        $this->assertFalse($methods['protectedMethod']->isFinal());
        $this->assertEquals($methods['protectedMethod']->getCode(),
                            'return $this->_bar ? true : false;'
                            );
        $this->assertEquals($methods['protectedMethod']->getDocComment(), "/**
     * protectedMethod()
     */");

        $this->assertFalse($methods['privateMethod']->isAbstract());
        $this->assertTrue($methods['privateMethod']->isPrivate());
        $this->assertFalse($methods['privateMethod']->isStatic());
        $this->assertFalse($methods['privateMethod']->isFinal());
        $this->assertEquals($methods['privateMethod']->getCode(), <<<PRIVATE_METHOD_CODE
/**
 * A document block in method.
 */
if (\$baz) {
    \$this->_baz = \$baz;
}
PRIVATE_METHOD_CODE
);
        $this->assertEquals($methods['privateMethod']->getDocComment(), "/**
     * privateMethod()
     */");

        $this->assertTrue($methods['abstractPublicMethod']->isAbstract());
        $this->assertTrue($methods['abstractPublicMethod']->isPublic());
        $this->assertFalse($methods['abstractPublicMethod']->isStatic());
        $this->assertFalse($methods['abstractPublicMethod']->isFinal());
        $this->assertFalse($methods['abstractPublicMethod']->isReference());
        $this->assertNull($methods['abstractPublicMethod']->getCode());
        $this->assertEquals($methods['abstractPublicMethod']->getDocComment(), "/**
     * abstractPublicMethod()
     */");
        $this->assertEquals(count($methods['abstractPublicMethod']->getArguments()), 0);


        $this->assertTrue($methods['abstractProtectedMethod']->isAbstract());
        $this->assertTrue($methods['abstractProtectedMethod']->isProtected());
        $this->assertFalse($methods['abstractProtectedMethod']->isStatic());
        $this->assertFalse($methods['abstractProtectedMethod']->isFinal());
        $this->assertFalse($methods['abstractProtectedMethod']->isReference());
        $this->assertNull($methods['abstractProtectedMethod']->getCode());
        $this->assertEquals($methods['abstractProtectedMethod']->getDocComment(), "/**
     * abstractProtectedMethod()
     */");
        $this->assertEquals(count($methods['abstractProtectedMethod']->getArguments()), 1);
    }

    /**
     * @test
     */
    public function parseAnExtendedClass()
    {
        $class = Stagehand_PHP_Class_Parser::parse($this->_extended);

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_AbstractTest_Bar');
        $this->assertEquals($class->getParentClass(), 'Stagehand_PHP_Class_Parser_AbstractTest_Foo');
        $this->assertFalse($class->isAbstract());
        $this->assertFalse($class->isInterface());
        $this->assertEquals($class->getDocComment(),"/**
 * A test class for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */");

        $this->assertEquals(count($class->getMethods()), 2);

        $class->setName('Stagehand_PHP_Class_Parser_AbstractTest_BarDummy');
        $class->load();
        $dummy = new Stagehand_PHP_Class_Parser_AbstractTest_BarDummy();

        $this->assertEquals($dummy->abstractPublicMethod(), 20);
        $this->assertEquals($dummy->baz, 'BAZ');
    }

    /**
     * @test
     */
    public function parseAnAbstractAndLoadWithOriginalClass()
    {
        $fooClass = Stagehand_PHP_Class_Parser::parse($this->_basic);
        $fooClass->setName('Stagehand_PHP_Class_Parser_AbstractTest_FooDummyTwo');

        $property = $fooClass->getProperty('baz');
        $property->setValue('Qux');

        $barClass = Stagehand_PHP_Class_Parser::parse($this->_extended);
        $barClass->setName('Stagehand_PHP_Class_Parser_AbstractTest_BarDummyTwo');
        $barClass->setParentClass($fooClass);

        $method = $barClass->getMethod('abstractPublicMethod');
        $method->setCode('return 10;');

        $barClass->load();
        $dummy = new Stagehand_PHP_Class_Parser_AbstractTest_BarDummyTwo(); 

        $this->assertEquals($dummy->abstractPublicMethod(), 10);
        $this->assertEquals($dummy->baz, 'Qux');
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
