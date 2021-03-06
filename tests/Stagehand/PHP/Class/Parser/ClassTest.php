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

// {{{ Stagehand_PHP_Class_Parser_ClassTest

/**
 * Some tests for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_Parser_ClassTest extends PHPUnit_Framework_TestCase
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
        $this->_basic = dirname(__FILE__) . '/ClassTest/Foo.php';
        $this->_extended = dirname(__FILE__) . '/ClassTest/Bar.php';
    }

    public function tearDown() { }

    /**
     * @test
     */
    public function parseAClass()
    {
        $class = Stagehand_PHP_Class_Parser::parse($this->_basic);

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_Foo');
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
    }

    /**
     * @test
     */
    public function parseAllConstantsOfAClass()
    {
        $class = Stagehand_PHP_Class_Parser::parse($this->_basic);

        $constants = $class->getConstants();

        $this->assertEquals(count($constants), 14);

        $this->assertEquals($constants['number']->getValue(), 10);
        $this->assertEquals($constants['string']->getValue(), 'example');
        $this->assertEquals($constants['namespace']->getValue(), 'Stagehand_PHP_Class_Parser_ClassTest_Foo::number');
        $this->assertEquals($constants['entryFoo']->getValue(), 20);
        $this->assertEquals($constants['entryBar']->getValue(), 30);
        $this->assertEquals($constants['null_value']->getValue(), null);
        $this->assertEquals($constants['null_string']->getValue(), 'null');
        $this->assertTrue($constants['true_value']->getValue());
        $this->assertEquals($constants['true_string']->getValue(), 'true');
        $this->assertFalse($constants['false_value']->getValue());
        $this->assertEquals($constants['false_string']->getValue(), 'false');

        $this->assertFalse($constants['number']->isParsable());
        $this->assertFalse($constants['string']->isParsable());
        $this->assertTrue($constants['namespace']->isParsable());
        $this->assertFalse($constants['entryFoo']->isParsable());
        $this->assertFalse($constants['entryBar']->isParsable());
        $this->assertFalse($constants['null_value']->isParsable());
        $this->assertFalse($constants['null_string']->isParsable());
        $this->assertFalse($constants['true_value']->isParsable());
        $this->assertFalse($constants['true_string']->isParsable());
        $this->assertFalse($constants['false_value']->isParsable());
        $this->assertFalse($constants['false_string']->isParsable());

        $class->setName('Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant');
        $class->load();

        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::number, 10);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::string, 'example');
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::namespace, 10);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::entryFoo, 20);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::entryBar, 30);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::entryBaz, 40);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::entryQux, 50);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::entryQuux, 60);
        $this->assertNull(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::null_value);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::null_string, 'null');
        $this->assertTrue(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::true_value);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::true_string, 'true');
        $this->assertFalse(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::false_value);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Constant::false_string, 'false');
    }

    /**
     * @test
     */
    public function parseAllPropertiesOfAClass()
    {
        $class = Stagehand_PHP_Class_Parser::parse($this->_basic);

        $properties = $class->getProperties();

        $this->assertEquals(count($properties), 32);

        $this->assertNull($properties['foo']->getValue());
        $this->assertEquals($properties['bar']->getValue(), 100);
        $this->assertEquals($properties['baz']->getValue(), 'BAZ');
        $this->assertEquals($properties['qux']->getValue(), array(1, 5, 10));
        $this->assertEquals($properties['quux']->getValue(), 'Stagehand_PHP_Class_Parser_ClassTest_Foo::string');
        $this->assertEquals($properties['corge']->getValue(), array('foo' => 'bar', 'baz' => 10));

        $this->assertEquals($properties['null_value']->getValue(), null);
        $this->assertEquals($properties['null_string']->getValue(), 'null');

        $this->assertFalse($properties['foo']->isParsable());
        $this->assertFalse($properties['bar']->isParsable());
        $this->assertFalse($properties['baz']->isParsable());
        $this->assertFalse($properties['qux']->isParsable());
        $this->assertTrue($properties['quux']->isParsable());
        $this->assertFalse($properties['null_value']->isParsable());
        $this->assertFalse($properties['null_string']->isParsable());

        $this->assertNull($properties['a']->getValue());
        $this->assertNull($properties['b']->getValue());
        $this->assertEquals($properties['c']->getValue(), 'c');
        $this->assertNull($properties['d']->getValue());
        $this->assertNull($properties['e']->getValue());
        $this->assertEquals($properties['f']->getValue(), 'f');
        $this->assertEquals($properties['g']->getValue(), 'g');
        $this->assertEquals($properties['h']->getValue(), 'h');
        $this->assertNull($properties['i']->getValue());
        $this->assertEquals($properties['j']->getValue(), 'j');

        $this->assertTrue($properties['foo']->isPublic());
        $this->assertTrue($properties['bar']->isPublic());
        $this->assertTrue($properties['bar']->isStatic());
        $this->assertTrue($properties['baz']->isPublic());
        $this->assertTrue($properties['qux']->isPublic());
        $this->assertTrue($properties['_bar']->isProtected());
        $this->assertTrue($properties['_baz']->isPrivate());

        $this->assertTrue($properties['a']->isPublic());
        $this->assertTrue($properties['b']->isPublic());
        $this->assertTrue($properties['c']->isPublic());
        $this->assertTrue($properties['d']->isPublic());
        $this->assertTrue($properties['e']->isPublic());
        $this->assertTrue($properties['f']->isPublic());
        $this->assertTrue($properties['g']->isPublic());
        $this->assertTrue($properties['h']->isPublic());
        $this->assertTrue($properties['i']->isPublic());
        $this->assertTrue($properties['i']->isStatic());
        $this->assertTrue($properties['j']->isPublic());
        $this->assertTrue($properties['j']->isStatic());

        $this->assertEquals($properties['foo']->getDocComment(), "/**
     * public foo
     */");
        $this->assertEquals($properties['bar']->getDocComment(), "/**
     * public static bar
     */");
        $this->assertEquals($properties['baz']->getDocComment(), "/**
     * var baz
     */");

        $this->assertEquals($properties['a']->getDocComment(), "/**
     * public a (not b)
     */");
        $this->assertNull($properties['b']->getDocComment());
        $this->assertNull($properties['c']->getDocComment());
        $this->assertNull($properties['d']->getDocComment());
        $this->assertNull($properties['e']->getDocComment());
        $this->assertNull($properties['f']->getDocComment());

        $class->setName('Stagehand_PHP_Class_Parser_ClassTest_Foo_Property');
        $class->load();
        $c = new Stagehand_PHP_Class_Parser_ClassTest_Foo_Property();

        $this->assertEquals($c->foo, null);
        $this->assertEquals(Stagehand_PHP_Class_Parser_ClassTest_Foo_Property::$bar, 100);
        $this->assertEquals($c->baz, 'BAZ');
        $this->assertEquals($c->qux[0], 1);
        $this->assertEquals($c->qux[1], 5);
        $this->assertEquals($c->qux[2], 10);
        $this->assertEquals($c->quux, 'example');
        $this->assertEquals($c->null_value, null);
        $this->assertEquals($c->null_string, 'null');
        $this->assertTrue($c->true_value);
        $this->assertEquals($c->true_string, 'true');
        $this->assertFalse($c->false_value);
        $this->assertEquals($c->false_string, 'false');
    }

    /**
     * @test
     */
    public function parseAllMethodsOfAClass()
    {
        $class = Stagehand_PHP_Class_Parser::parse($this->_basic);

        $methods = $class->getMethods();

        $this->assertEquals(count($methods), 8);

        $this->assertTrue($methods['__construct']->isPublic());
        $this->assertFalse($methods['__construct']->isStatic());
        $this->assertFalse($methods['__construct']->isFinal());
        $this->assertFalse($methods['__construct']->isReference());
        $this->assertNull($methods['__construct']->getCode());
        $this->assertEquals($methods['__construct']->getDocComment(), "/**
     * __construct()
     */");
        $this->assertEquals(count($methods['__construct']->getArguments()), 0);

        $this->assertTrue($methods['reference']->isPublic());
        $this->assertFalse($methods['reference']->isStatic());
        $this->assertFalse($methods['reference']->isFinal());
        $this->assertTrue($methods['reference']->isReference());
        $this->assertEquals($methods['reference']->getCode(), <<<REFERENCE_METHOD_CODE
\$result = \$foo + 1;
return \$result;
REFERENCE_METHOD_CODE
);
        $this->assertEquals($methods['reference']->getDocComment(), "/**
     * reference()
     */");

        $referenceArguments = $methods['reference']->getArguments();

        $this->assertEquals(count($referenceArguments), 1);
        $this->assertNull($referenceArguments['foo']->getValue());
        $this->assertTrue($referenceArguments['foo']->isRequired());

        $this->assertTrue($methods['someArguments']->isPublic());
        $this->assertFalse($methods['someArguments']->isStatic());
        $this->assertFalse($methods['someArguments']->isFinal());
        $this->assertFalse($methods['someArguments']->isReference());
        $this->assertNull($methods['someArguments']->getCode());
        $this->assertNull($methods['someArguments']->getDocComment());

        $someArguments = $methods['someArguments']->getArguments();

        $this->assertEquals(count($someArguments), 10);

        $this->assertNull($someArguments['a']->getValue());
        $this->assertNull($someArguments['b']->getValue());
        $this->assertNull($someArguments['c']->getValue());
        $this->assertEquals($someArguments['d']->getValue(), 10);
        $this->assertEquals($someArguments['e']->getValue(), 'EEE');
        $this->assertEquals($someArguments['f']->getValue(), array(1, 3, 5));
        $this->assertNull($someArguments['g']->getValue());
        $this->assertEquals($someArguments['h']->getValue(), 'Stagehand_PHP_Class_Parser_ClassTest_Foo::namespace');
        $this->assertTrue($someArguments['i']->getValue());
        $this->assertFalse($someArguments['j']->getValue());

        $this->assertTrue($someArguments['a']->isRequired());
        $this->assertTrue($someArguments['b']->isRequired());
        $this->assertTrue($someArguments['c']->isRequired());
        $this->assertFalse($someArguments['d']->isRequired());
        $this->assertFalse($someArguments['e']->isRequired());
        $this->assertFalse($someArguments['f']->isRequired());
        $this->assertFalse($someArguments['g']->isRequired());
        $this->assertFalse($someArguments['h']->isRequired());
        $this->assertFalse($someArguments['i']->isRequired());
        $this->assertFalse($someArguments['j']->isRequired());

        $this->assertFalse($someArguments['a']->isParsable());
        $this->assertFalse($someArguments['b']->isParsable());
        $this->assertFalse($someArguments['c']->isParsable());
        $this->assertFalse($someArguments['d']->isParsable());
        $this->assertFalse($someArguments['e']->isParsable());
        $this->assertFalse($someArguments['f']->isParsable());
        $this->assertFalse($someArguments['g']->isParsable());
        $this->assertTrue($someArguments['h']->isParsable());
        $this->assertFalse($someArguments['i']->isParsable());
        $this->assertFalse($someArguments['j']->isParsable());

        $this->assertTrue($someArguments['a']->isReference());
        $this->assertFalse($someArguments['b']->isReference());
        $this->assertFalse($someArguments['c']->isReference());
        $this->assertFalse($someArguments['d']->isReference());
        $this->assertFalse($someArguments['e']->isReference());
        $this->assertFalse($someArguments['f']->isReference());
        $this->assertFalse($someArguments['g']->isReference());
        $this->assertFalse($someArguments['h']->isReference());
        $this->assertFalse($someArguments['i']->isReference());
        $this->assertFalse($someArguments['j']->isReference());

        $this->assertNull($someArguments['a']->getTypeHinting());
        $this->assertEquals($someArguments['b']->getTypeHinting(), 'array');
        $this->assertEquals($someArguments['c']->getTypeHinting(), 'stdclass');
        $this->assertNull($someArguments['d']->getTypeHinting());
        $this->assertNull($someArguments['e']->getTypeHinting());
        $this->assertNull($someArguments['f']->getTypeHinting());
        $this->assertNull($someArguments['g']->getTypeHinting());
        $this->assertNull($someArguments['h']->getTypeHinting());
        $this->assertNull($someArguments['i']->getTypeHinting());
        $this->assertNull($someArguments['j']->getTypeHinting());

        $this->assertTrue($methods['staticMethod']->isPublic());
        $this->assertTrue($methods['staticMethod']->isStatic());
        $this->assertFalse($methods['staticMethod']->isFinal());
        $this->assertNull($methods['someArguments']->getDocComment(), "/**
     * staticMethod()
     */");

        $this->assertTrue($methods['finalMethod']->isPublic());
        $this->assertFalse($methods['finalMethod']->isStatic());
        $this->assertTrue($methods['finalMethod']->isFinal());
        $this->assertEquals($methods['finalMethod']->getDocComment() ,"/**
     * finalMethod()
     */");

        $this->assertTrue($methods['protectedMethod']->isProtected());
        $this->assertFalse($methods['protectedMethod']->isStatic());
        $this->assertFalse($methods['protectedMethod']->isFinal());
        $this->assertEquals($methods['protectedMethod']->getCode(),
                            'return $this->_bar ? true : false;'
                            );
        $this->assertEquals($methods['protectedMethod']->getDocComment(), "/**
     * protectedMethod()
     */");

        $this->assertTrue($methods['finalStaticProtectedMethod']->isProtected());
        $this->assertTrue($methods['finalStaticProtectedMethod']->isStatic());
        $this->assertTrue($methods['finalStaticProtectedMethod']->isFinal());
        $this->assertEquals($methods['finalStaticProtectedMethod']->getDocComment(), "/**
     * finalStaticProtectedMethod()
     */");

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


        $class->setName('Stagehand_PHP_Class_Parser_ClassTest_FooDummy');
        $class->load();
        $dummy = new Stagehand_PHP_Class_Parser_ClassTest_FooDummy();

        $this->assertEquals($dummy->reference(10), 11);
    }

    /**
     * @test
     */
    public function parseAnExtendedClass()
    {
        $class = Stagehand_PHP_Class_Parser::parse($this->_extended);

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_Bar');
        $this->assertEquals($class->getParentClass(), 'Stagehand_PHP_Class_Parser_ClassTest_Foo');
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

        $methods = $class->getMethods();

        $this->assertEquals(count($methods), 1);
        $this->assertTrue($methods['reference']->isPublic());

        $class->setName('Stagehand_PHP_Class_Parser_ClassTest_BarDummy');
        $class->load();
        $dummy = new Stagehand_PHP_Class_Parser_ClassTest_BarDummy();

        $this->assertEquals($dummy->reference(10), 20);
        $this->assertEquals($dummy->baz, 'BAZ');
    }

    /**
     * @test
     */
    public function parseAClassWithInterfaces()
    {
        $class = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__) .
                                               '/ClassTest/HasOneInterface.php'
                                               );

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_HasOneInterface');

        $interfaces = $class->getInterfaces();

        $this->assertEquals(count($interfaces), 1);
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_ClassTest_InterfaceOne'],
                            'Stagehand_PHP_Class_Parser_ClassTest_InterfaceOne'
                            );

        $class = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__) .
                                               '/ClassTest/HasThreeInterfaces.php'
                                               );

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_HasThreeInterface');

        $interfaces = $class->getInterfaces();

        $this->assertEquals(count($interfaces), 3);
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_ClassTest_InterfaceOne'],
                            'Stagehand_PHP_Class_Parser_ClassTest_InterfaceOne'
                            );
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_ClassTest_InterfaceTwo'],
                            'Stagehand_PHP_Class_Parser_ClassTest_InterfaceTwo'
                            );
        $this->assertEquals($interfaces['Stagehand_PHP_Class_Parser_ClassTest_InterfaceThree'],
                            'Stagehand_PHP_Class_Parser_ClassTest_InterfaceThree'
                            );
    }

    /**
     * @test
     */
    public function parseTwoClassesInOneFileScript()
    {
        $classes = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__) . '/ClassTest/Baz.php');

        $this->assertEquals(count($classes), 2);

        $baz = $classes[0];
        $exception = $classes[1];

        $this->assertType('Stagehand_PHP_Class', $baz);
        $this->assertEquals($baz->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_Baz');
        $this->assertNull($baz->getParentClass());
        $this->assertFalse($baz->isAbstract());
        $this->assertFalse($baz->isInterface());
        $this->assertEquals($baz->getDocComment(),"/**
 * A test class for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */");
        $this->assertEquals(count($baz->getConstants()), 2);
        $this->assertEquals(count($baz->getProperties()), 4);
        $this->assertEquals(count($baz->getMethods()), 3);


        $this->assertType('Stagehand_PHP_Class', $exception);
        $this->assertEquals($exception->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_BazException');
        $this->assertEquals($exception->getParentClass(), 'Exception');
        $this->assertFalse($exception->isAbstract());
        $this->assertFalse($exception->isInterface());
        $this->assertEquals($exception->getDocComment(),"/**
 * A test exception class for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */");
        $this->assertEquals(count($exception->getConstants()), 0);
        $this->assertEquals(count($exception->getProperties()), 0);
        $this->assertEquals(count($exception->getMethods()), 0);
    }

    /**
     * @test
     */
    public function parseAClassWithPreAndPostCodeOfClassDeclaration()
    {
        $class = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__) . '/ClassTest/HasOtherCodes.php');

        $this->assertType('Stagehand_PHP_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_HasOtherCodes');

        $this->assertEquals($class->getPreCode(), <<<PRE_CODE




\$a = 10;
define('Stagehand_PHP_Class_Parser_ClassTest_HasOtherCodes_Foo', 10);
Stagehand_PHP_Class_Parser_ClassTest_HasOtherCodes_Bar::doMethod(10, 20, 30);

function stagehand_class_parser_classTest_hasOtherCodes_baz(\$baz)
{
    return \$baz * 2;
}
__halt_compiler();
const Stagehand_PHP_Class_Parser_ClassTest_HasOtherCodes_FooConst = 10;
PRE_CODE
);

        $this->assertEquals($class->getPostCode(), <<<POST_CODE



Stagehand_PHP_Class_Parser_ClassTest_HasOtherCode::doMethodA();
Stagehand_PHP_Class_Parser_ClassTest_HasOtherCode::doMethodB('foo');
POST_CODE
);
    }

    /**
     * @test
     */
    public function parseSomeClassesWithPreAndPostCodeOfClassDeclaration()
    {
        $classes = Stagehand_PHP_Class_Parser::parse(dirname(__FILE__)
                                                 . '/ClassTest/HasOtherCodesTwo.php'
                                                 );

        $this->assertEquals(count($classes), 3);

        $foo = $classes[0];
        $bar = $classes[1];
        $baz = $classes[2];

        $this->assertType('Stagehand_PHP_Class', $foo);
        $this->assertEquals($foo->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_HasOtherCodesTwo_Foo');
        $this->assertEquals($foo->getPreCode(), '$a = 10;');
        $this->assertEquals($foo->getPostCode(), '

$b = 20;');

        $this->assertType('Stagehand_PHP_Class', $bar);
        $this->assertEquals($bar->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_HasOtherCodesTwo_Bar');
        $this->assertEquals($bar->getPreCode(), '

$b = 20;');
        $this->assertEquals($bar->getPostCode(), '

$c = 30;');

        $this->assertType('Stagehand_PHP_Class', $baz);
        $this->assertEquals($baz->getName(), 'Stagehand_PHP_Class_Parser_ClassTest_HasOtherCodesTwo_Baz');
        $this->assertEquals($baz->getPreCode(), '

$c = 30;');
        $this->assertEquals($baz->getPostCode(), '

$d = 40;');
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
