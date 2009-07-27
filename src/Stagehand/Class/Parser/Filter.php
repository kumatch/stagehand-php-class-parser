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
    private $_currentMethods = array();

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

    // }}}
    // {{{ getCurrentMethods()

    /**
     * Gets all current methods.
     *
     * @return array
     */
    public function getCurrentMethods()
    {
        return $this->_currentMethods;
    }

    // }}}
    // {{{ addCurrentMethod

    /**
     * Adds a current method.
     *
     * @param Stagehand_Class_Method $method
     */
    public function addCurrentMethod(Stagehand_Class_Method $method)
    {
        array_push($this->_currentMethods, $method);
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
        return $params[0]->getValue();
    }

    /**
     * namespace_name_2
     *    namespace_name T_NS_SEPARATOR T_STRING
     */
    protected function namespace_name_2($params)
    {
        return array($params[0],
                     $params[1]->getValue(),
                     $params[2]->getValue(),
                     );                     
    }






    /**
     * common_scalar_1
     *    T_LNUMBER
     */
    protected function common_scalar_1($params)
    {
        $scalar = $params[0]->getValue();
        return (int)$scalar;
    }

    /**
     * common_scalar_2
     *    T_DNUMBER
     */
    protected function common_scalar_2($params)
    {
        $scalar = $params[0]->getValue();
        return (float)$scalar;
    }

    /**
     * common_scalar_3
     *    T_CONSTANT_ENCAPSED_STRING
     */
    protected function common_scalar_3($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_4
     *    T_LINE
     */
    protected function common_scalar_4($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_5
     *    T_FILE
     */
    protected function common_scalar_5($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_6
     *    T_DIR
     */
    protected function common_scalar_6($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_7
     *    T_CLASS_C
     */
    protected function common_scalar_7($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_8
     *    T_METHOD_C
     */
    protected function common_scalar_8($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_9
     *    T_FUNC_C
     */
    protected function common_scalar_9($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_10
     *    T_NS_C
     */
    protected function common_scalar_10($params)
    {
        return $params[0]->getValue();
    }

    /**
     * common_scalar_11
     *    start_heredoc T_ENCAPSED_AND_WHITESPACE T_END_HEREDOC
     */
    protected function common_scalar_11($params)
    {
        return array($params[0],
                     $params[1]->getValue(),
                     $params[2]->getValue(),
                     );
    }

    /**
     * common_scalar_12
     *    start_heredoc T_END_HEREDOC
     */
    protected function common_scalar_12($params)
    {
        return array($params[0],
                     $params[1]->getValue(),
                     );
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
        return array($params[0]->getValue(),
                     $params[1]->getValue(),
                     $params[2],
                     );
    }

    /**
     * static_scalar_4
     *    T_NS_SEPARATOR namespace_name
     */
    protected function static_scalar_4($params)
    {
        return array($params[0]->getValue(),
                     $params[1],
                     );
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
        return array($params[0],
                     $params[1]->getValue(),
                     $params[2]->getValue(),
                     );
    }




    /**
     * static_array_pair_list_1
     *    // empty //
     */
    protected function static_array_pair_list_1($params)
    {
        return new ArrayObject();
    }

    /**
     * static_array_pair_list_2
     *    non_empty_static_array_pair_list possible_comma
     */
    protected function static_array_pair_list_2($params)
    {
        $list = new ArrayObject();
        foreach ($params[0] as $param) {
            $list->append($param);
        }

        return $list;
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
        return $params[0]->getValue();
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
        return array($params[0]->getValue(),
                     $params[1]->getValue(),
                     $params[2],
                     );
    }

    /**
     * class_name_4
     *    T_NS_SEPARATOR namespace_name
     */
    protected function class_name_4($params)
    {
        return array($params[0]->getValue(),
                     $params[1],
                     );
    }




    /**
     * unticked_class_declaration_statement_1
     *    class_entry_type T_STRING extends_from implements_list '{' class_statement_list '}'
     */
    protected function unticked_class_declaration_statement_1($params)
    {
        $className = $params[1]->getValue();
        $class = new Stagehand_Class($className);
        if ($params[0] === 'abstract') {
            $class->defineAbstract();
        } elseif ($params[1] === 'final') {
            $class->defineFinal();
        }

        if ($params[2]) {
            $class->setParentClass($params[2]);
        }

        $lex = $this->getParser()->lex;
        $docComment = $lex->getLatestDocComment();
        if ($docComment) {
            $class->setDocComment($docComment, true);
        }

        foreach ($this->getCurrentConstants() as $constant) {
            $class->addConstant($constant);
        }

        foreach ($this->getCurrentProperties() as $property) {
            $class->addProperty($property);
        }

        foreach ($this->getCurrentMethods() as $method) {
            $class->addMethod($method);
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
     * class_entry_type_1
     *    T_CLASS
     */
    protected function class_entry_type_1($params)
    {
        return $params[0]->getValue();
    }

    /**
     * class_entry_type_2
     *    T_ABSTRACT T_CLASS
     */
    protected function class_entry_type_2($params)
    {
        return $params[0]->getValue();
    }

    /**
     * class_entry_type_3
     *    T_FINAL T_CLASS
     */
    protected function class_entry_type_3($params)
    {
        return $params[0]->getValue();
    }





    /**
     * extends_from_1
     *    // empty //
     */
    protected function extends_from_1($params)
    {
        return null;
    }

    /**
     * extends_from_2
     *    T_EXTENDS fully_qualified_class_name
     */
    protected function extends_from_2($params)
    {
        return $params[1];
    }







    /**
     * class_constant_declaration_1
     *    class_constant_declaration ',' T_STRING '=' static_scalar
     */
    protected function class_constant_declaration_1($params)
    {
        $this->_declar_class_constant($params[2]->getValue(),
                                      $params[4]
                                      );
        return parent::execute(__FUNCTION__, $params);
    }

    /**
     * class_constant_declaration_2
     *    T_CONST T_STRING '=' static_scalar
     */
    protected function class_constant_declaration_2($params)
    {
        $this->_declar_class_constant($params[1]->getValue(),
                                      $params[3]
                                      );
        return parent::execute(__FUNCTION__, $params);
    }

    protected function _declar_class_constant($name, $scalar)
    {
        $constant = new Stagehand_Class_Constant($name);

        if (is_array($scalar)) {
            $constant->setValue(implode('', $scalar), true);
        } else {
            $value = $this->_getVariableValue($scalar);
            $constant->setValue($value);
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
            $this->_setModifiers($property, $variableModifiers);
            $this->addCurrentProperty($property);
        }

        return parent::execute(__FUNCTION__, $params);
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
        if (is_array($params[0])) {
            $methodModifiers = $params[0];
        } else {
            $methodModifiers = array($params[0]);
        }

        $isReference   = $params[2] ? true : false;
        $methodName    = $params[3]->getValue();
        $parameterList = $params[5];
        $methodBody    = $params[7] ? $params[7] : null;

        $method = new Stagehand_Class_Method($methodName);
        $method->setCode($methodBody);

        $lex = $this->getParser()->lex;
        $docComment = $lex->getLatestDocComment();
        if ($docComment) {
            $method->setDocComment($docComment, true);
        }

        if ($isReference) {
            $method->setReference();
        }

        if ($parameterList) {
            foreach ($parameterList as $argument) {
                $method->addArgument($argument);
            }
        }

        $this->_setModifiers($method, $methodModifiers);
        $this->addCurrentMethod($method);

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
        return $params[0]->getValue();
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
        if (is_array($params[0])) {
            array_push($params[0], $params[1]);
            return $params[0];
        } else {
            return array($params[0], $params[1]);
        }
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
        return $params[0]->getValue();
    }

    protected function member_modifier_2($params)
    {
        return $params[0]->getValue();
    }

    protected function member_modifier_3($params)
    {
        return $params[0]->getValue();
    }

    protected function member_modifier_4($params)
    {
        return $params[0]->getValue();
    }

    protected function member_modifier_5($params)
    {
        return $params[0]->getValue();
    }

    protected function member_modifier_6($params)
    {
        return $params[0]->getValue();
    }


    /**
     *  class_variable_declaration_1
     *    class_variable_declaration ',' T_VARIABLE
     */
    protected function class_variable_declaration_1($params)
    {
        if (is_array($params[0])) {
            $variableDeclarations = $params[0];
        } else {
            $variableDeclarations = array($params[0]);
        }

        array_push($variableDeclarations,
                   $this->class_variable_declaration_3(array($params[2]))
                   );

        return $variableDeclarations;
    }

    /**
     *  class_variable_declaration_2
     *    class_variable_declaration ',' T_VARIABLE '=' static_scalar
     */
    protected function class_variable_declaration_2($params)
    {
        if (is_array($params[0])) {
            $variableDeclarations = $params[0];
        } else {
            $variableDeclarations = array($params[0]);
        }

        array_push($variableDeclarations,
                   $this->class_variable_declaration_4(array($params[2], $params[3], $params[4]))
                   );

        return $variableDeclarations;
    }

    /**
     *  class_variable_declaration_3
     *    T_VARIABLE
     */
    protected function class_variable_declaration_3($params)
    {
        $name = $this->_getVariableName($params[0]->getValue());
        $property = new Stagehand_Class_Property($name);

        $lex = $this->getParser()->lex;
        $docComment = $lex->getLatestDocComment();
        if ($docComment) {
            $property->setDocComment($docComment, true);
        }

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

        $lex = $this->getParser()->lex;
        $docComment = $lex->getLatestDocComment();
        if ($docComment) {
            $property->setDocComment($docComment, true);
        }

        if (is_array($params[2])) {
            $property->setValue(implode('', $params[2]), true);
        } else {
            $property->setValue($this->_getStaticScalarValue($params[2]));
        }

        return $property;
    }





    /**
     * method_modifiers_1
     *    // empty
     */
    protected function method_modifiers_1($params)
    {
        return null;
    }

    /**
     * method_modifiers_2
     *    non_empty_member_modifiers
     */
    protected function method_modifiers_2($params)
    {
        return $params[0];
    }



    /**
     * function_1
     *    T_FUNCTION
     */
    protected function function_1($params)
    {
        return $params[0]->getValue();
    }


    /**
     * is_reference_1
     *    // empty
     */
    protected function is_reference_1($params)
    {
        return null;
    }

    /**
     * is_reference_2
     *    '&'
     */
    protected function is_reference_2($params)
    {

        return $params[0]->getValue();
    }




    /**
     * parameter_list_1
     *    non_empty_parameter_list
     */
    protected function parameter_list_1($params)
    {
        return $params[0];
    }

    /**
     * parameter_list_2
     *    // empty
     */
    protected function parameter_list_2($params)
    {
        return null;
    }




    /**
     * non_empty_parameter_list_1
     *    optional_class_type T_VARIABLE
     */
    protected function non_empty_parameter_list_1($params)
    {
        $name = preg_replace('/^\$/', '', $params[1]->getValue());
        $argument = new Stagehand_Class_Method_Argument($name);
        $argument->setRequirement(true);

        if ($params[0]) {
            $argument->setTypeHinting($params[0]);
        }

        return array($argument);
    }

    /**
     * non_empty_parameter_list_2
     *    optional_class_type '&' T_VARIABLE
     */
    protected function non_empty_parameter_list_2($params)
    {
        $arguments = $this->non_empty_parameter_list_1(array($params[0], $params[2]));
        $arguments[0]->setReference();

        return $arguments;
    }

    /**
     * non_empty_parameter_list_3
     *    optional_class_type '&' T_VARIABLE '=' static_scalar
     */
    protected function non_empty_parameter_list_3($params)
    {
        $arguments = $this->non_empty_parameter_list_1(array($params[0], $params[2]));
        $arguments[0]->setReference();
        $arguments[0]->setValue($params[4]->getValue());
        $arguments[0]->setRequirement(false);

        return $arguments;
    }

    /**
     * non_empty_parameter_list_4
     *    optional_class_type T_VARIABLE '=' static_scalar
     */
    protected function non_empty_parameter_list_4($params)
    {
        $arguments = $this->non_empty_parameter_list_1(array($params[0], $params[1]));
        $arguments[0]->setReference();
        $arguments[0]->setValue($params[3]->getValue());
        $arguments[0]->setRequirement(false);

        return $arguments;
    }

    /**
     * non_empty_parameter_list_5
     *    non_empty_parameter_list ',' optional_class_type T_VARIABLE
     */
    protected function non_empty_parameter_list_5($params)
    {
        $arguments = $this->non_empty_parameter_list_1(array($params[2], $params[3]));
        array_push($params[0], $arguments[0]);

        return $params[0];
    }

    /**
     * non_empty_parameter_list_6
     *    non_empty_parameter_list ',' optional_class_type '&' T_VARIABLE
     */
    protected function non_empty_parameter_list_6($params)
    {
        $arguments = $this->non_empty_parameter_list_1(array($params[2], $params[4]));
        $arguments[0]->setReference();
        array_push($params[0], $arguments[0]);

        return $params[0];
    }

    /**
     * non_empty_parameter_list_7
     *    non_empty_parameter_list ',' optional_class_type '&' T_VARIABLE '=' static_scalar
     */
    protected function non_empty_parameter_list_7($params)
    {
        $arguments = $this->non_empty_parameter_list_1(array($params[2], $params[4]));
        $arguments[0]->setReference();
        $arguments[0]->setValue($params[6]->getValue());
        $arguments[0]->setRequirement(false);
        array_push($params[0], $arguments[0]);

        return $params[0];
    }

    /**
     * non_empty_parameter_list_8
     *    non_empty_parameter_list ',' optional_class_type T_VARIABLE '=' static_scalar
     */
    protected function non_empty_parameter_list_8($params)
    {
        $arguments = $this->non_empty_parameter_list_1(array($params[2], $params[3]));

        if (is_array($params[5])) {
            $arguments[0]->setValue(implode('', $params[5]), true);
        } else {
            $arguments[0]->setValue($this->_getStaticScalarValue($params[5]));
        }

        $arguments[0]->setRequirement(false);
        array_push($params[0], $arguments[0]);

        return $params[0];
    }







    /**
     * optional_class_type_1
     *    // empty
     */
    protected function optional_class_type_1($params)
    {
        return null;
    }

    /**
     * optional_class_type_2
     *    fully_qualified_class_name
     */
    protected function optional_class_type_2($params)
    {
        return $params[0];
    }

    /**
     * optional_class_type_3
     *    T_ARRAY
     */
    protected function optional_class_type_3($params)
    {
        return $params[0]->getValue();
    }





    /**
     * fully_qualified_class_name_1
     *    namespace_name
     */
    protected function fully_qualified_class_name_1($params)
    {
        return $params[0];
    }

    /**
     * fully_qualified_class_name_2
     *    T_NAMESPACE T_NS_SEPARATOR namespace_name
     */
    protected function fully_qualified_class_name_2($params)
    {
        return array($params[0]->getValue(),
                     $params[1]->getValue(),
                     $params[2],
                     );
    }

    /**
     * fully_qualified_class_name_3
     *    T_NS_SEPARATOR namespace_name
     */
    protected function fully_qualified_class_name_3($params)
    {
        return array($params[0]->getValue(),
                     $params[1],
                     );
    }








    /**
     * method_body_1
     *    ';' // abstract method
     */
    protected function method_body_1($params)
    {
        return null;
    }

    /**
     * method_body_2
     *    '{' inner_statement_list '}'
     */
    protected function method_body_2($params)
    {
        $lex = $this->getParser()->lex;
        $codeTokens = $lex->getTokens($params[0]->getPosition() + 1,
                                      $params[2]->getPosition() - 1
                                      );

        $indent = null;
        if (is_array($codeTokens[0])
            && token_name($codeTokens[0][0]) === 'T_WHITESPACE'
            ) {
            $token = array_shift($codeTokens);

            foreach (explode("\n", preg_replace("/\r\n/", "\n", $token[1])) as $line) {
                if (preg_match('/^[\s]+$/', $line)
                    && strlen($line) >strlen($indent)) {
                    $indent = $line;
                }
            }
        }

        if (!$count = count($codeTokens)) {
            return null;
        }

        $lastToken = end($codeTokens);
        if (is_array($lastToken)
            && token_name($lastToken[0]) === 'T_WHITESPACE'
            ) {
            array_pop($codeTokens);
        }

        $code = null;
        foreach ($codeTokens as $token) {
            $code .= is_array($token) ? $token[1] : $token;
        }

        $indentedCode = null;
        foreach (explode("\n", preg_replace("/\r\n/", "\n", $code)) as $line) {
            if ($indentedCode) {
                $indentedCode .= "\n";
            }
            $indentedCode .= preg_replace("/^{$indent}/", '', $line);
        }

        return $indentedCode;
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

    protected function _getStaticScalarValue($scalar)
    {
        if ($scalar instanceof ArrayObject) {
            $value = (array)$scalar;
        } else {
            if (($scalar === 'null')) {
                $value = null;
            } else {
                $value = $this->_getVariableValue($scalar);
            }
        }

        return $value;
    }

    protected function _setModifiers(&$declar, $modifiers)
    {
        foreach ($modifiers as $modifier) {
            switch (strtolower($modifier)) {
            case 'public':
            case 'var':
                $declar->definePublic();
                break;
            case 'protected':
                $declar->defineProtected();
                break;
            case 'private':
                $declar->definePrivate();
                break;
            case 'static':
                $declar->defineStatic();
                break;
            case 'abstract':
                $declar->defineAbstract();
                break;
            case 'final':
                $declar->defineFinal();
                break;
            default:
                break;
            }
        }
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
