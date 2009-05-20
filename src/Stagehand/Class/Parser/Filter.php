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
    private $_currentProperties = array();

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

    // }}}
    // {{{ getCurrentProperties()

    /**
     * Gets all current properties.
     *
     * @return array
     */
    public function getCurrentProperties()
    {
        return $this->_currentProperties;
    }

    // }}}
    // {{{ addCurrentProperty

    /**
     * Adds a current property.
     *
     * @param Stagehand_Class_Property $property
     */
    public function addCurrentProperty(Stagehand_Class_Property $property)
    {
        array_push($this->_currentProperties, $property);
    }


    /**#@-*/

    /**#@+
     * @access protected
     */

    /**
     * start_1:
     *    top_statement_list
     */
    protected function start_1($params)
    {
        return $params;
    }

    /**
     * top_statement_list_1:
     *    top_statement_list top_statement
     */
    protected function top_statement_list_1($params)
    {
        $params[0]->addValue($params[1]);
        return $params[0];
    }

    /**
     * inner_statement_list_1:
     *    inner_statement_list inner_statement
     */
    protected function inner_statement_list_1($params)
    {
        $params[0]->addValue($params[1]);
        return $params[0];
    }

    /**
     * class_statement_list_1:
     *    class_statement_list class_statement
     */
    protected function class_statement_list_1($params)
    {
        $params[0]->addValue($params[1]);
        return $params[0];
    }

    /**
     * interface_list_2:
     *    interface_list ',' fully_qualified_class_name
     */
    protected function interface_list_2($params)
    {
        $params[0]->addValue($params[1]);
        $params[0]->addValue($params[2]);
        return $params[0];
    }



    /**
     * namespace_name_1
     *    T_STRING
     */
    protected function namespace_name_1($params)
    {
        return $params[0];
    }

    /**
     * namespace_name_2
     *    namespace_name T_NS_SEPARATOR T_STRING
     */
    protected function namespace_name_2($params)
    {
        return implode('', $params);
    }






    /**
     * common_scalar_1
     *    T_LNUMBER
     */
    protected function common_scalar_1($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_2
     *    T_DNUMBER
     */
    protected function common_scalar_2($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_3
     *    T_CONSTANT_ENCAPSED_STRING
     */
    protected function common_scalar_3($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_4
     *    T_LINE
     */
    protected function common_scalar_4($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_5
     *    T_FILE
     */
    protected function common_scalar_5($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_6
     *    T_DIR
     */
    protected function common_scalar_6($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_7
     *    T_CLASS_C
     */
    protected function common_scalar_7($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_8
     *    T_METHOD_C
     */
    protected function common_scalar_8($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_9
     *    T_FUNC_C
     */
    protected function common_scalar_9($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_10
     *    T_NS_C
     */
    protected function common_scalar_10($params)
    {
        return $params[0];
    }

    /**
     * common_scalar_11
     *    start_heredoc T_ENCAPSED_AND_WHITESPACE T_END_HEREDOC
     */
    protected function common_scalar_11($params)
    {
        return implode('', $params);
    }

    /**
     * common_scalar_12
     *    start_heredoc T_END_HEREDOC
     */
    protected function common_scalar_12($params)
    {
        return implode('', $params);
    }




    /**
     * static_scalar_1
     *    common_scalar
     */
    protected function static_scalar_1($params)
    {
        return $params[0];
    }

    /**
     * static_scalar_2
     *    namespace_name
     */
    protected function static_scalar_2($params)
    {
        return $params[0];
    }

    /**
     * static_scalar_3
     *    T_NAMESPACE T_NS_SEPARATOR namespace_name
     */
    protected function static_scalar_3($params)
    {
        return implode('', $params);
    }

    /**
     * static_scalar_4
     *    T_NS_SEPARATOR namespace_name
     */
    protected function static_scalar_4($params)
    {
        return implode('', $params);
    }

    /**
     * static_scalar_5
     *    '+' static_scalar
     */
    protected function static_scalar_5($params)
    {
        return '+' . $params[1];
    }

    /**
     * static_scalar_6
     *    '-' static_scalar
     */
    protected function static_scalar_6($params)
    {
        return '-' . $params[1];
    }

    /**
     * static_scalar_7
     *    T_ARRAY '(' static_array_pair_list ')'
     */
    protected function static_scalar_7($params)
    {
        return $params[2];
    }

    /**
     * static_scalar_8
     *    static_class_constant
     */
    protected function static_scalar_8($params)
    {
        return $params[0];
    }



    /**
     * static_class_constant_1
     *    class_name T_PAAMAYIM_NEKUDOTAYIM T_STRING
     */
    protected function static_class_constant_1($params)
    {
        return $params;
    }




    /**
     * static_array_pair_list_1
     *    // empty //
     */
    protected function static_array_pair_list_1($params)
    {
        return $params;
    }

    /**
     * static_array_pair_list_2
     *    non_empty_static_array_pair_list possible_comma
     */
    protected function static_array_pair_list_2($params)
    {
        return $params[0];
    }



    /**
     * non_empty_static_array_pair_list_1
     *    non_empty_static_array_pair_list ',' static_scalar T_DOUBLE_ARROW static_scalar
     */
    protected function non_empty_static_array_pair_list_1($params)
    {
        array_push($params[0], array($params[2], $params[3], $params[4]));
        return $params[0];
    }

    /**
     * non_empty_static_array_pair_list_2
     *    non_empty_static_array_pair_list ',' static_scalar
     */
    protected function non_empty_static_array_pair_list_2($params)
    {
        array_push($params[0], $params[2]);
        return $params[0];
    }

    /**
     * non_empty_static_array_pair_list_3
     *    static_scalar T_DOUBLE_ARROW static_scalar
     */
    protected function non_empty_static_array_pair_list_3($params)
    {
        return array($params);
    }

    /**
     * non_empty_static_array_pair_list_4
     *    static_scalar
     */
    protected function non_empty_static_array_pair_list_4($params)
    {
        return array($params[0]);
    }





    /**
     * class_name_1
     *    T_STATIC
     */
    protected function class_name_1($params)
    {
        return $params[0];
    }

    /**
     * class_name_2
     *    namespace_name
     */
    protected function class_name_2($params)
    {
        return $params[0];
    }

    /**
     * class_name_3
     *    T_NAMESPACE T_NS_SEPARATOR namespace_name
     */
    protected function class_name_3($params)
    {
        return implode('', $params);
    }

    /**
     * class_name_4
     *    T_NS_SEPARATOR namespace_name
     */
    protected function class_name_4($params)
    {
        return implode('', $params);
    }




    /**
     * unticked_class_declaration_statement_1
     *    class_entry_type T_STRING extends_from implements_list '{' class_statement_list '}'
     */
    protected function unticked_class_declaration_statement_1($params)
    {
        $className = $params[1]->getValue();
        $class = new Stagehand_Class($className);

        foreach ($this->getCurrentConstants() as $constant) {
            $class->addConstant($constant);
        }

        foreach ($this->getCurrentProperties() as $property) {
            $class->addProperty($property);
        }

        $this->addClass($class);

        return parent::execute(__FUNCTION__, $params);
    }

    /**
     * unticked_class_declaration_statement_2
     *    interface_entry T_STRING interface_extends_list '{' class_statement_list '}'
     */
    protected function unticked_class_declaration_statement_2($params)
    {
/*         var_dump($params[1]); */
        return parent::execute(__FUNCTION__, $params);
    }




    /**
     * class_constant_declaration_1
     *    class_constant_declaration ',' T_STRING '=' static_scalar
     */
    protected function class_constant_declaration_1($params)
    {
        $this->_declar_class_constant($params[2], $params[4]);
        return parent::execute(__FUNCTION__, $params);
    }

    /**
     * class_constant_declaration_2
     *    T_CONST T_STRING '=' static_scalar
     */
    protected function class_constant_declaration_2($params)
    {
        $this->_declar_class_constant($params[1], $params[3]);
        return parent::execute(__FUNCTION__, $params);
    }

    protected function _declar_class_constant($nameToken, $valueToken)
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
            $value = $this->_getVariableValue($valueToken->getValue());
            $constant->setValue($value);

        } else {
            throw new Stagehand_Class_Parser_Exception('Syntax error in class constants');
        }

        $this->addCurrentConstant($constant);
    }



    
    /**
     * class_statement_1
     *    variable_modifiers class_variable_declaration ';'
     */
    protected function class_statement_1($params)
    {
        if (is_array($params[0])) {
            $variableModifiers = $params[0];
        } else {
            $variableModifiers = array($params[0]);
        }

        if (is_array($params[1])) {
            $variableDeclarations = $params[1];
        } else {
            $variableDeclarations = array($params[1]);
        }

        foreach ($variableDeclarations as $property) {
            foreach ($variableModifiers as $variableModifier) {
                switch (strtolower($variableModifier->getValue())) {
                case 'public':
                case 'var':
                    $property->definePublic();
                    break;
                case 'protected':
                    $property->defineProtected();
                    break;
                case 'private':
                    $property->definePrivate();
                    break;
                case 'static':
                    $property->defineStatic();
                    break;
                default:
                    break;
                }
            }

            $this->addCurrentProperty($property);
        }
    }

    /**
     * class_statement_2
     *    class_constant_declaration ';'
     */
    protected function class_statement_2($params)
    {
        return parent::execute(__FUNCTION__, $params);
    }

    /**
     * class_statement_3
     *    method_modifiers function is_reference T_STRING '(' parameter_list ')' method_body
     */
    protected function class_statement_3($params)
    {
/*         var_dump('class_statement_3'); */
/*         var_dump($params); */
        return parent::execute(__FUNCTION__, $params);
    }









    /**
     * variable_modifiers_1
     *    non_empty_member_modifiers
     */
    protected function variable_modifiers_1($params)
    {
        return $params[0];
    }

    /**
     * variable_modifiers_2
     *    T_VAR
     */
    protected function variable_modifiers_2($params)
    {
        return $params[0];
    }



    /**
     * non_empty_member_modifiers_1
     *    member_modifier
     */
    protected function non_empty_member_modifiers_1($params)
    {
        return $params[0];
    }

    /**
     * non_empty_member_modifiers_2
     *    non_empty_member_modifiers member_modifier
     */
    protected function non_empty_member_modifiers_2($params)
    {
        return array($params[0], $params[1]);
    }


    /**
     *  member_modifier:
     *    T_PUBLIC
     *    T_PROTECTED
     *    T_PRIVATE
     *    T_STATIC
     *    T_ABSTRACT
     *    T_FINAL
     */
    protected function member_modifier_1($params)
    {
        return $params[0];
    }

    protected function member_modifier_2($params)
    {
        return $params[0];
    }

    protected function member_modifier_3($params)
    {
        return $params[0];
    }

    protected function member_modifier_4($params)
    {
        return $params[0];
    }

    protected function member_modifier_5($params)
    {
        return $params[0];
    }

    protected function member_modifier_6($params)
    {
        return $params[0];
    }


    /**
     *  class_variable_declaration_1
     *    class_variable_declaration ',' T_VARIABLE
     */
    protected function class_variable_declaration_1($params)
    {
        return array($params[0],
                     $this->class_variable_declaration_3(array($params[2]))
                     );
    }

    /**
     *  class_variable_declaration_2
     *    class_variable_declaration ',' T_VARIABLE '=' static_scalar
     */
    protected function class_variable_declaration_2($params)
    {
        return array($params[0],
                     $this->class_variable_declaration_4(array($params[2],
                                                               $params[3],
                                                               $params[4],
                                                               )
                                                         )
                     );
    }

    /**
     *  class_variable_declaration_3
     *    T_VARIABLE
     */
    protected function class_variable_declaration_3($params)
    {
        $name = $this->_getVariableName($params[0]->getValue());
        $property = new Stagehand_Class_Property($name);

        return $property;
    }

    /**
     *  class_variable_declaration_4
     *    T_VARIABLE '=' static_scalar
     */
    protected function class_variable_declaration_4($params)
    {
        $name = $this->_getVariableName($params[0]->getValue());
        $property = new Stagehand_Class_Property($name);

        if (is_array($params[2])) {
            $value = null;
            foreach ($params[2] as $param) {
                $value .= $param->getValue();
            }
            $property->setValue($value, true);

        } else {
            $value = $this->_getVariableValue($params[2]->getValue());
            $property->setValue($value);
        }

        return $property;
    }








    protected function _getVariableName($name)
    {
        return preg_replace('/^\$/', '', $name);
    }

    protected function _getVariableValue($value)
    {
        if (preg_match("/^'(.*)'$/", $value, $matches)) {
            $value = $matches[1];
        }

        return $value;
    }


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
