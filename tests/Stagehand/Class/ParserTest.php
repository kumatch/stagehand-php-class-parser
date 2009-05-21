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
 * @package    sh-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

// {{{ Stagehand_Class_ParserTest

/**
 * Some tests for Stagehand_Class_Parser
 *
 * @package    sh-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_Class_ParserTest extends PHPUnit_Framework_TestCase
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
        $this->_filename = dirname(__FILE__) . '/ParserTest/Foo.php';
    }

    public function tearDown() { }

    /**
     * @test
     */
    public function parseAClass()
    {
        $class = Stagehand_Class_Parser::parse($this->_filename);

        $this->assertType('Stagehand_Class', $class);
        $this->assertEquals($class->getName(), 'Stagehand_Class_ParserTest_Foo');
        $this->assertFalse($class->isAbstract());
        $this->assertFalse($class->isInterface());
    }

    /**
     * @test
     */
    public function parseAllConstantsOfAClass()
    {
        $class = Stagehand_Class_Parser::parse($this->_filename);

        $constants = $class->getConstants();

        $this->assertEquals(count($constants), 8);

        $this->assertEquals($constants['number']->getValue(), 10);
        $this->assertEquals($constants['string']->getValue(), 'example');
        $this->assertEquals($constants['namespace']->getValue(), 'Stagehand_Class_ParserTest_Foo::number');
        $this->assertEquals($constants['entryFoo']->getValue(), 20);
        $this->assertEquals($constants['entryBar']->getValue(), 30);

        $this->assertFalse($constants['number']->isParsable());
        $this->assertFalse($constants['string']->isParsable());
        $this->assertTrue($constants['namespace']->isParsable());
        $this->assertFalse($constants['entryFoo']->isParsable());
        $this->assertFalse($constants['entryBar']->isParsable());
    }

    /**
     * @test
     */
    public function parseAllPropertiesOfAClass()
    {
        $class = Stagehand_Class_Parser::parse($this->_filename);

        $properties = $class->getProperties();

        $this->assertEquals(count($properties), 25);

        $this->assertNull($properties['foo']->getValue());
        $this->assertEquals($properties['bar']->getValue(), 100);
        $this->assertEquals($properties['baz']->getValue(), 'BAZ');
        $this->assertEquals($properties['qux']->getValue(), array(1, 5, 10));
        $this->assertEquals($properties['quux']->getValue(), 'Stagehand_Class_ParserTest_Foo::string');

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
    }

    /**
     * @test
     */
    public function parseAllMethodsOfAClass()
    {
        $class = Stagehand_Class_Parser::parse($this->_filename);

        $methods = $class->getMethods();

        $this->assertEquals(count($methods), 8);

        $this->assertTrue($methods['__construct']->isPublic());
        $this->assertFalse($methods['__construct']->isStatic());
        $this->assertFalse($methods['__construct']->isFinal());
        $this->assertFalse($methods['__construct']->isReference());
        $this->assertNull($methods['__construct']->getCode());
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

        $referenceArguments = $methods['reference']->getArguments();

        $this->assertEquals(count($referenceArguments), 1);
        $this->assertNull($referenceArguments['foo']->getValue());
        $this->assertTrue($referenceArguments['foo']->isRequired());

        $this->assertTrue($methods['someArguments']->isPublic());
        $this->assertFalse($methods['someArguments']->isStatic());
        $this->assertFalse($methods['someArguments']->isFinal());
        $this->assertFalse($methods['someArguments']->isReference());
        $this->assertNull($methods['someArguments']->getCode());

        $someArguments = $methods['someArguments']->getArguments();

        $this->assertEquals(count($someArguments), 8);

        $this->assertNull($someArguments['a']->getValue());
        $this->assertNull($someArguments['b']->getValue());
        $this->assertNull($someArguments['c']->getValue());
        $this->assertEquals($someArguments['d']->getValue(), 10);
        $this->assertEquals($someArguments['e']->getValue(), 'EEE');
        $this->assertEquals($someArguments['f']->getValue(), array(1, 3, 5));
        $this->assertNull($someArguments['g']->getValue());
        $this->assertEquals($someArguments['h']->getValue(), 'Stagehand_Class_ParserTest_Foo::namespace');

        $this->assertTrue($someArguments['a']->isRequired());
        $this->assertTrue($someArguments['b']->isRequired());
        $this->assertTrue($someArguments['c']->isRequired());
        $this->assertFalse($someArguments['d']->isRequired());
        $this->assertFalse($someArguments['e']->isRequired());
        $this->assertFalse($someArguments['f']->isRequired());
        $this->assertFalse($someArguments['g']->isRequired());
        $this->assertFalse($someArguments['h']->isRequired());

        $this->assertFalse($someArguments['a']->isParsable());
        $this->assertFalse($someArguments['b']->isParsable());
        $this->assertFalse($someArguments['c']->isParsable());
        $this->assertFalse($someArguments['d']->isParsable());
        $this->assertFalse($someArguments['e']->isParsable());
        $this->assertFalse($someArguments['f']->isParsable());
        $this->assertFalse($someArguments['g']->isParsable());
        $this->assertTrue($someArguments['h']->isParsable());

        $this->assertTrue($someArguments['a']->isReference());
        $this->assertFalse($someArguments['b']->isReference());
        $this->assertFalse($someArguments['c']->isReference());
        $this->assertFalse($someArguments['d']->isReference());
        $this->assertFalse($someArguments['e']->isReference());
        $this->assertFalse($someArguments['f']->isReference());
        $this->assertFalse($someArguments['g']->isReference());
        $this->assertFalse($someArguments['h']->isReference());

        $this->assertNull($someArguments['a']->getTypeHinting());
        $this->assertEquals($someArguments['b']->getTypeHinting(), 'array');
        $this->assertEquals($someArguments['c']->getTypeHinting(), 'stdclass');
        $this->assertNull($someArguments['d']->getTypeHinting());
        $this->assertNull($someArguments['e']->getTypeHinting());
        $this->assertNull($someArguments['f']->getTypeHinting());
        $this->assertNull($someArguments['g']->getTypeHinting());
        $this->assertNull($someArguments['h']->getTypeHinting());

        $this->assertTrue($methods['staticMethod']->isPublic());
        $this->assertTrue($methods['staticMethod']->isStatic());
        $this->assertFalse($methods['staticMethod']->isFinal());

        $this->assertTrue($methods['finalMethod']->isPublic());
        $this->assertFalse($methods['finalMethod']->isStatic());
        $this->assertTrue($methods['finalMethod']->isFinal());

        $this->assertTrue($methods['protectedMethod']->isProtected());
        $this->assertFalse($methods['protectedMethod']->isStatic());
        $this->assertFalse($methods['protectedMethod']->isFinal());
        $this->assertEquals($methods['protectedMethod']->getCode(),
                            'return $this->_bar ? true : false;'
                            );

        $this->assertTrue($methods['finalStaticProtectedMethod']->isProtected());
        $this->assertTrue($methods['finalStaticProtectedMethod']->isStatic());
        $this->assertTrue($methods['finalStaticProtectedMethod']->isFinal());

        $this->assertTrue($methods['privateMethod']->isPrivate());
        $this->assertFalse($methods['privateMethod']->isStatic());
        $this->assertFalse($methods['privateMethod']->isFinal());
        $this->assertEquals($methods['privateMethod']->getCode(), <<<PRIVATE_METHOD_CODE
if (\$baz) {
    \$this->_baz = \$baz;
}
PRIVATE_METHOD_CODE
);

        $class->setName('Dummy');
        $class->load();
        $dummy = new Dummy();

        $this->assertEquals($dummy->reference(10), 11);
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
