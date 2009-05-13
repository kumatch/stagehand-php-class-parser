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

// {{{ Stagehand_Class_Parser_Filter

/**
 * A filter class for parsing PHP class.
 *
 * @package    sh-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Stagehand_Class_Parser_Filter extends Stagehand_PHP_Parser_Dumb
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

    private $_classes = array();

    /**#@-*/

    /**#@+
     * @access public
     */

    // }}}
    // {{{ execute()

    /**
     * Executes parser filter.
     *
     * @param string $name
     * @param string $params
     * @return mixed
     */
    public function execute($name, $params)
    {
        if (method_exists($this, $name)) {
            return $this->$name($params);
        } else {
            return parent::execute($name, $params);
        }
    }

    // }}}
    // {{{ getClasses()

    /**
     * Gets all classes.
     *
     * @return array
     */
    public function getClasses()
    {
        return $this->_classes;
    }

    // }}}
    // {{{ addClass

    /**
     * Adds a class.
     *
     * @param Stagehand_Class $calss
     */
    public function addClass($class)
    {
        array_push($this->_classes, $class);
    }

    /**#@-*/

    /**#@+
     * @access protected
     */

    /**#@-*/

    /**#@+
     * @access private
     */

    private function start_1($params)
    {
        return $params;
    }

    private function top_statement_list_1($params)
    {
        $params[0]->addValue($params[1]);
        return $params[0];
    }

    private function inner_statement_list_1($params)
    {
        $params[0]->addValue($params[1]);
        return $params[0];
    }

    private function class_statement_list_1($params)
    {
        $params[0]->addValue($params[1]);
        return $params[0];
    }

    private function interface_list_2($params)
    {
        $params[0]->addValue($params[1]);
        $params[0]->addValue($params[2]);
        return $params[0];
    }




    private function unticked_class_declaration_statement_1($params)
    {
        $className = $params[1]->getValue();
        $this->addClass(new Stagehand_Class($className));

        return parent::execute(__FUNCTION__, $params);
    }

    private function unticked_class_declaration_statement_2($params)
    {
        var_dump($params[1]);
        return parent::execute(__FUNCTION__, $params);
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
