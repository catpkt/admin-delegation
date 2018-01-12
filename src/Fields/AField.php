<?php

namespace CatPKT\AdminDelegation\Fields;

use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

abstract class AField
{
	use TGetter;

	/**
	 * Constant IS_SCALAR
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const IS_SCALAR= 0;

	/**
	 * Constant IS_COMPLEX
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const IS_COMPLEX= 1;

	/**
	 * Constant IS_SIMPLE
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const IS_SIMPLE= 0;

	/**
	 * Constant IS_ARRAY
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const IS_ARRAY= 2;

	/**
	 * Constant DATUM_SCALAR
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const DATUM_SIMPLE_SCALAR= 0;

	/**
	 * Constant DATUM_COMPLEX_SCALAR
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const DATUM_COMPLEX_SCALAR= 1;

	/**
	 * Constant DATUM_SIMPLE_ARRAY
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const DATUM_SIMPLE_ARRAY= 2;

	/**
	 * Constant DATUM_COMPLEX_ARRAY
	 *
	 * @access public
	 *
	 * @const    int
	 */
	const DATUM_COMPLEX_ARRAY= 3;

	/**
	 * Var rules
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $rules= [];

	/**
	 * Var name
	 *
	 * @access protected
	 *
	 * @var    string
	 */
	protected $name;

	/**
	 * Var label
	 *
	 * @access protected
	 *
	 * @var    string
	 */
	protected $label;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 */
	public function __construct( string$name, string$label=null )
	{
		$this->name= $name;
		$this->label= $label??$name;

		$this->rules['type']= self::parseType();
	}

	/**
	 * 设为必填字段
	 *
	 * @access public
	 *
	 * @param  bool $required
	 *
	 * @return static
	 */
	public function required( bool$required=true ):self
	{
		$this->rules['required']= $required;

		return $this;
	}

	/**
	 * 设为隐藏字段
	 *
	 * @access public
	 *
	 * @param  bool $hidden
	 *
	 * @return static
	 */
	public function hidden( bool$hidden=true ):self
	{
		$this->rules['hidden']= $hidden;

		return $this;
	}

	/**
	 * 在列表中显示字段
	 *
	 * @access public
	 *
	 * @param  bool $showInList
	 *
	 * @return static
	 */
	public function showInList( bool$showInList=true ):self
	{
		$this->rules['show_in_list']= $showInList;

		return $this;
	}

	/**
	 * 设为只读字段
	 *
	 * @access public
	 *
	 * @param  bool $showInList
	 *
	 * @return static
	 */
	public function readOnly( bool$showInList=true ):self
	{
		$this->rules['show_in_list']= $showInList;

		return $this;
	}

	/**
	 * Static method parseType
	 *
	 * @static
	 *
	 * @access protected
	 *
	 * @return string
	 */
	protected static function parseType():string
	{
		return strtocamel(
			str_replace( 'Field', '',
				strrstr( static::class, '\\', true )
			)
		);
	}

	/**
	 * Method getType
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getType():string
	{
		return $this->rules['type'];
	}

	/**
	 * Method getName
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getName():string
	{
		return $this->name;
	}

	/**
	 * Method getLabel
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getLabel():string
	{
		return $this->label;
	}

	/**
	 * Method getRules
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getRules():array
	{
		return $this->rules;
	}

	/**
	 * Method getRule
	 *
	 * @access public
	 *
	 * @param string $name
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function getRule( string$name, $default=null )
	{
		return $this->rules[$name]??$default;
	}

	/**
	 * Method isScalar
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function isScalar():bool
	{
		return true;
	}

	/**
	 * Method isArray
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function isArray():bool
	{
		return !$this->isScalar();
	}

	/**
	 * Method isComplex
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function isComplex():bool
	{
		return false;
	}

	/**
	 * Method getDatumType
	 *
	 * @access public
	 *
	 * @return int
	 */
	public function getDatumType():int
	{
		return ($this->isArray())|($this->isComplex()<1);
	}

	/**
	 * Method activedSubFields
	 *
	 * @access public
	 *
	 * @param  mixed $value
	 *
	 * @return ?FiledSet
	 */
	public function activedSubFields( $value )
	{
		return null;
	}

}
