<?php

namespace CatPKT\AdminDelegation\Fields;

use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

abstract class AField
{
	use TGetter;

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

}
