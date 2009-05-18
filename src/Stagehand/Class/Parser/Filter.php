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

    private $_currentConstants = array();

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
    public function addClass(Stagehand_Class $class)
    {
        array_push($this->_classes, $class);
    }


    // }}}
    // {{{ getCurrentConstants()

    /**
     * Gets all current constants.
     *
     * @return array
     */
    public function getCurrentConstants()
    {
        return $this->_currentConstants;
    }

    // }}}
    // {{{ addCurrentConstant

    /**
     * Adds a current constant.
     *
     * @param Stagehand_Class_Constant $constant
     */
    public function addCurrentConstant(Stagehand_Class_Constant $constant)
    {
        array_push($this->_currentConstants, $constant);
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



    /**
     * namespace_names
     *
     * @param mixed $params
     */
    private function namespace_name_1($params)
    {
        return $params[0];
    }

    private function namespace_name_2($params)
    {
        return implode('', $params);
    }






    /**
     * common_scalars
     *
     * @param mixed $params
     */
    private function common_scalar_1($params)
    {
        return $params[0];
    }

    private function common_scalar_2($params)
    {
        return $params[0];
    }

    private function common_scalar_3($params)
    {
        return $params[0];
    }

    private function common_scalar_4($params)
    {
        return $params[0];
    }

    private function common_scalar_5($params)
    {
        return $params[0];
    }

    private function common_scalar_6($params)
    {
        return $params[0];
    }

    private function common_scalar_7($params)
    {
        return $params[0];
    }

    private function common_scalar_8($params)
    {
        return $params[0];
    }

    private function common_scalar_9($params)
    {
        return $params[0];
    }

    private function common_scalar_10($params)
    {
        return $params[0];
    }

    private function common_scalar_11($params)
    {
        return implode('', $params);
    }

    private function common_scalar_12($params)
    {
        return implode('', $params);
    }




    /**
     * static_scalars
     *
     * @param mixed $params
     */
    private function static_scalar_1($params)
    {
        return $params[0];
    }

    private function static_scalar_2($params)
    {
        return $params[0];
    }

    private function static_scalar_3($params)
    {
        return implode('', $params);
    }

    private function static_scalar_4($params)
    {
        return implode('', $params);
    }

    private function static_scalar_5($params)
    {
        return '+' . $params[1];
    }

    private function static_scalar_6($params)
    {
        return '-' . $params[1];
    }

    private function static_scalar_7($params)
    {
        return $params[2];
    }

    private function static_scalar_8($params)
    {
        return $params[0];
    }



    /**
     * static_class_constant
     *
     * @param mixed $params
     */
    private function static_class_constant_1($params)
    {
        return $params;
    }




    /**
     * static_array_pair_lists
     *
     * @param mixed $params
     */
    private function static_array_pair_list_1($params)
    {
        return $params;
    }

    private function static_array_pair_list_2($params)
    {
        return $params[0];
    }



    /**
     * non_empty_static_array_pair_lists
     *
     * @param mixed $params
     */
    private function non_empty_static_array_pair_list_1($params)
    {
        array_push($params[0], array($params[2], $params[3], $params[4]));
        return $params[0];
    }

    private function non_empty_static_array_pair_list_2($params)
    {
        array_push($params[0], $params[2]);
        return $params[0];
    }

    private function non_empty_static_array_pair_list_3($params)
    {
        return array($params);
    }

    private function non_empty_static_array_pair_list_4($params)
    {
        return array($params[0]);
    }





    /**
     * class names
     *
     * @param mixed $params
     */
    private function class_name_1($params)
    {
        return $params[0];
    }

    private function class_name_2($params)
    {
        return $params[0];
    }

    private function class_name_3($params)
    {
        return implode('', $params);
    }

    private function class_name_4($params)
    {
        return implode('', $params);
    }




    /**
     * declar a class.
     *
     * @param mixed $params
     */
    private function unticked_class_declaration_statement_1($params)
    {
        $className = $params[1]->getValue();
        $class = new Stagehand_Class($className);

        foreach ($this->getCurrentConstants() as $constant) {
            $class->addConstant($constant);
        }

        $this->addClass($class);

        return parent::execute(__FUNCTION__, $params);
    }

    private function unticked_class_declaration_statement_2($params)
    {
/*         var_dump($params[1]); */
        return parent::execute(__FUNCTION__, $params);
    }




    /**
     * declar a class constant.
     *
     * @param mixed $params
     */
    private function class_constant_declaration_1($params)
    {
        $this->_declar_class_constant($params[2], $params[4]);
        return parent::execute(__FUNCTION__, $params);
    }

    private function class_constant_declaration_2($params)
    {
        $this->_declar_class_constant($params[1], $params[3]);
        return parent::execute(__FUNCTION__, $params);
    }

    private function _declar_class_constant($nameToken, $valueToken)
    {
        $name  = $nameToken->getValue();
        $constant = new Stagehand_Class_Constant($name);

        if (is_array($valueToken)) {
            $value = null;
            foreach ($valueToken as $param) {
                if ($param instanceof Stagehand_PHP_Lexer_Token) {
                    $value .= $param->getValue();
                } else {
                    throw new Stagehand_Class_Parser_Exception('Arrays are not allowed in class constants');
                }
            }
            $constant->setValue($value, true);

        } elseif ($valueToken instanceof Stagehand_PHP_Lexer_Token) {
            $value = $valueToken->getValue();
            if (preg_match("/^'(.*)'$/", $value, $matches)) {
                $value = $matches[1];
            }
            $constant->setValue($value);

        } else {
            throw new Stagehand_Class_Parser_Exception('Syntax error in class constants');
        }

        $this->addCurrentConstant($constant);
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
