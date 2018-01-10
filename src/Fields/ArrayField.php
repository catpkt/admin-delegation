<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 数组 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class ArrayField extends AField
{

	/**
	 * 设置元素字段
	 *
	 * @access public
	 *
	 * @param  {class extends AField} $fieldClass
	 *
	 * @return AField
	 */
	public function addField( string$fieldClass ):AField
	{
		if(!(
			class_exists( $fieldClass )
		and
			$field= new $fieldClass( $this->name, $this->label )
		and
			$field instanceof AField
		))
		{
			throw new \TypeError( 'Argument 1 passed to '.__METHOD__.'() must be a class extends CatPKT\AdminDelegation\Fields\AField, strange things given' );
		}

		return $this->rules['field']= $field;
	}

	/**
	 * 设置元素为 字符串 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function string():StringField
	{
		return $this->addField( StringField::class );
	}

	/**
	 * 设置元素为 URL 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function url():StringField
	{
		return $this->addField( StringField::class )->asUrl();
	}

	/**
	 * 设置元素为 电话号码 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function tel():StringField
	{
		return $this->addField( StringField::class )->asTel();
	}

	/**
	 * 设置元素为 Email 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function email():StringField
	{
		return $this->addField( StringField::class )->asEmail();
	}

	/**
	 * 设置元素为 多行字符串 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return StringField
	 */
	public function multiLineString():StringField
	{
		return $this->addField( StringField::class )->multiLine();
	}

	/**
	 * 设置元素为 富文本 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return HtmlField
	 */
	public function html():HtmlField
	{
		return $this->addField( HtmlField::class );
	}

	/**
	 * 设置元素为 代码 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return CodeField
	 */
	public function code():CodeField
	{
		return $this->addField( CodeField::class );
	}

	/**
	 * 设置元素为 数字 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return NumberField
	 */
	public function number():NumberField
	{
		return $this->addField( NumberField::class );
	}

	/**
	 * 设置元素为 布尔 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return BoolField
	 */
	public function bool():BoolField
	{
		return $this->addField( BoolField::class );
	}

	/**
	 * 设置元素为 选择 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return SelectorField
	 */
	public function selector():SelectorField
	{
		return $this->addField( SelectorField::class );
	}

	/**
	 * 设置元素为 多选 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return SelectorField
	 */
	public function multiSelector():SelectorField
	{
		return $this->addField( SelectorField::class )->multiple();
	}

	/**
	 * 设置元素为 日期时间 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return DateTimeField
	 */
	public function dateTime():DateTimeField
	{
		return $this->addField( DateTimeField::class );
	}

	/**
	 * 设置元素为 日期 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return DateTimeField
	 */
	public function date():DateTimeField
	{
		return $this->addField( DateTimeField::class )->asDate();
	}

	/**
	 * 设置元素为 时间 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return DateTimeField
	 */
	public function time():DateTimeField
	{
		return $this->addField( DateTimeField::class )->asTime();
	}

	/**
	 * 设置元素为 图片 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return DateTimeField
	 */
	public function picture():PictureField
	{
		return $this->addField( PictureField::class );
	}

	/**
	 * 设置元素为 时间 字段
	 *
	 * @access public
	 *
	 * @param  string $name
	 * @param  string $label
	 *
	 * @return ModelField
	 */
	public function model():ModelField
	{
		return $this->addField( ModelField::class );
	}

}
