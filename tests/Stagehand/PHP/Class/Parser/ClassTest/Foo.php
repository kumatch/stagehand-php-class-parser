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

// {{{ Stagehand_PHP_Class_Parser_ClassTest_Foo

/**
 * A test class for Stagehand_PHP_Class_Parser
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_PHP_Class_Parser_ClassTest_Foo
{
    const number = 10;
    const string = 'example';
    const namespace = Stagehand_PHP_Class_Parser_ClassTest_Foo::number;
    const entryFoo = 20, entryBar = 30;
    const entryBaz = 40, entryQux = 50, entryQuux = 60;
    const null_value = null;
    const null_string = 'null';
    const true_value = true;
    const true_string = 'true';
    const false_value = false;
    const false_string = 'false';
    // const $dummy1 = 100;
    /* const $dummy2 = 200; */

    /**#@+
     * @access public
     */

    /**
     * public foo
     */
    public $foo;

    /**
     * public static bar
     */
    public static $bar = 100;

    /**
     * var baz
     */
    var $baz = 'BAZ';

    public $qux = array(1, 5, 10);
    public $quux = Stagehand_PHP_Class_Parser_ClassTest_Foo::string;
    public $corge = array('foo' => 'bar', 'baz' => 10);
    public $null_value = null;
    public $null_string = 'null';
    public $true_value = true;
    public $true_string = 'true';
    public $false_value = false;
    public $false_string = 'false';
    // public $dummy1;
    /* public $dummy2; */

    /**
     * public a (not b)
     */
    public $a, $b;
    public $c = 'c', $d;
    public $e, $f = 'f';
    public $g = 'g', $h = 'h';
    public static $i, $j = 'j';

    public $aa, $aaa, $aaaa, $aaaaa;
    public $bb = 10, $bbb = 20, $bbbb = 30, $bbbbb = 40;
    
    /**#@-*/

    /**#@+
     * @access protected
     */

    protected $_bar;

    /**#@-*/

    /**#@+
     * @access private
     */

    private $_baz;

    /**#@-*/

    /**#@+
     * @access public
     */

    /**
     * __construct()
     */
    public function __construct()
    {
    }

    /**
     * reference()
     */
    public function &reference($foo)
    {
        $result = $foo + 1;
        return $result;
    }

    public function someArguments(&$a, array $b, stdClass $c,
                                  $d = 10, $e = 'EEE', $f = array(1, 3, 5),
                                  $g = null, $h = Stagehand_PHP_Class_Parser_ClassTest_Foo::namespace,
                                  $i = true, $j = false)
    {
    }

    /**
     * staticMethod()
     */
    public static function staticMethod()
    {
    }

    /**
     * finalMethod()
     */
    final public function finalMethod()
    {
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**
     * protectedMethod()
     */
    protected function protectedMethod()
    {
        return $this->_bar ? true : false;
    }

    /**
     * finalStaticProtectedMethod()
     */
    final protected static function finalStaticProtectedMethod()
    {
    }

    /**#@-*/

    /**#@+
     * @access private
     */

    /**
     * privateMethod()
     */
    private function privateMethod($baz)
    {
        /**
         * A document block in method.
         */
        if ($baz) {
            $this->_baz = $baz;
        }
    }

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
