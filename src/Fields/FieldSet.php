<?php

namespace CatPKT\AdminDelegation\Fields;

use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

/**
 * 字段集
 *
 * $method  string()            增加一个 字符串 字段
 * $method  url()               增加一个 URL 字段
 * $method  tel()               增加一个 电话号码 字段
 * $method  email()             增加一个 Email 字段
 * $method  multiLineString()   增加一个 多行字符串 字段
 * $method  html()              增加一个 富文本 字段
 * $method  number()            增加一个 数字 字段
 * $method  bool()              增加一个 布尔 字段
 * $method  selector()          增加一个 选择 字段
 * $method  multiSelector()     增加一个 多选 字段
 * $method  dateTime()          增加一个 日期时间 字段
 * $method  date()              增加一个 日期 字段
 * $method  time()              增加一个 时间 字段
 * $method  model()             增加一个 模型 字段
 * $method  addField( AField )  增加一个字段
 */
final class FieldSet implements \IteratorAggregate
{

	/**
	 * Var fields
	 *
	 * @access protected
	 *
	 * @var    array [AField]
	 */
	protected $fields= [];

	/**
	 * 增加一个字段
	 *
	 * @access public
	 *
	 * @param  AField $field
	 *
	 * @return AField
	 */
	public function addField( AField$field ):AField
	{
		return $this->fields[$field->name]= $field;
	}

	/**
	 * 增加一个 字符串 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function string( string$name, string$label=null ):StringField
	{
		return $this->addField( new StringField( $name, $label ) );
	}

	/**
	 * 增加一个 URL 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function url( string$name, string$label=null ):StringField
	{
		return $this->addField( new StringField( $name, $label ) )->asUrl();
	}

	/**
	 * 增加一个 电话号码 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function tel( string$name, string$label=null ):StringField
	{
		return $this->addField( new StringField( $name, $label ) )->asTel();
	}

	/**
	 * 增加一个 Email 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function email( string$name, string$label=null ):StringField
	{
		return $this->addField( new StringField( $name, $label ) )->asEmail();
	}

	/**
	 * 增加一个 多行字符串 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function multiLineString( string$name, string$label=null ):StringField
	{
		return $this->addField( new StringField( $name, $label ) )->multiLine();
	}

	/**
	 * 增加一个 富文本 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return HtmlField
	 */
	public function html( string$name, string$label=null ):HtmlField
	{
		return $this->addField( new HtmlField( $name, $label ) )->multiLine();
	}

	/**
	 * 增加一个 数字 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return NumberField
	 */
	public function number( string$name, string$label=null ):NumberField
	{
		return $this->addField( new NumberField( $name, $label ) );
	}

	/**
	 * 增加一个 布尔 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return BoolField
	 */
	public function bool( string$name, string$label=null ):BoolField
	{
		return $this->addField( new BoolField( $name, $label ) );
	}

	/**
	 * 增加一个 选择 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return SelectorField
	 */
	public function selector( string$name, string$label=null ):SelectorField
	{
		return $this->addField( new SelectorField( $name, $label ) );
	}

	/**
	 * 增加一个 多选 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return SelectorField
	 */
	public function multiSelector( string$name, string$label=null ):SelectorField
	{
		return $this->addField( new SelectorField( $name, $label ) )->multiple();
	}

	/**
	 * 增加一个 日期时间 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return DateTimeField
	 */
	public function dateTime( string$name, string$label=null ):DateTimeField
	{
		return $this->addField( new DateTimeField( $name, $label ) );
	}

	/**
	 * 增加一个 日期 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return DateTimeField
	 */
	public function date( string$name, string$label=null ):DateTimeField
	{
		return $this->addField( new DateTimeField( $name, $label ) )->asDate();
	}

	/**
	 * 增加一个 时间 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return DateTimeField
	 */
	public function time( string$name, string$label=null ):DateTimeField
	{
		return $this->addField( new DateTimeField( $name, $label ) )->asTime();
	}

	/*\
	 * ┌┘
	 *─┤ 以上为后台委托者需要关心的部分
	 * └─────────────────────────────┘
	\*/

	/**
	 * Method getKeys
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getKeys():array
	{
		return array_map( function( $field ){

			return $field->name;

		}, $this->fields );
	}

	/**
	 * Method getIterator
	 *
	 * @access public
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator():\ArrayIterator
	{
		return new \ArrayIterator( $this->fields );
	}

}
