<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 选择 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class SelectorField extends AField
{

	/**
	 * 设置选项
	 *
	 * @access public
	 *
	 * @param  string $value
	 * @param  string $label
	 * @param  FieldSet $label
	 *
	 * @return static
	 */
	public function option( string$value, string$label, FieldSet$subFields=null ):self
	{
		$this->rules['options'][$value]= [ 'label'=>$label, 'sub_fields'=>$subFields, ];

		return $this;
	}

	/**
	 * 批量设置选项
	 *
	 * @access public
	 *
	 * @param  array $options 支持两种格式
	 *  [
	 *  	$value=> $label,
	 *  ];
	 *  [
	 *  	$value=> [
	 *  		'label'=> $label,
	 *  		'subFields'=> $subFilds,
	 *  	],
	 *  ];
	 *
	 * @return static
	 */
	public function options( array$options ):self
	{
		foreach( $options as $value=>$option )
		{
			if( is_array( $option ) )
			{
				$this->option( $value, $option['label']??$value, $option['subFields']??null );
			}else{
				$this->option( $value, $option );
			}
		}

		return $this;
	}

	/**
	 * 设为 可多选
	 *
	 * @access public
	 *
	 * @param  bool $multiple
	 *
	 * @return static
	 */
	public function multiple( bool$multiple=true ):self
	{
		$this->rules['multiple']= $multiple;

		return $this;
	}

	/**
	 * 设为 分散显示
	 *   默认使用 <select> 标签 分散显示则使用多个 <radio> 或 <checkbox> 标签
	 *
	 * @access public
	 *
	 * @param  bool $dispersed
	 *
	 * @return static
	 */
	public function dispersed( bool$dispersed=true ):self
	{
		$this->rules['dispersed']= $dispersed;

		return $this;
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
		return !($this->rules['multiple']??null);
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
		$options= $this->rules['options']??[];

		if( $this->isScalar() )
		{
			return ($options[$value]??[])['sub_fields']??null;
		}
		else
		{
			$activedSubFieldSets= array_filter(
				array_map( function( $value )use( $options ){
					return ($options[$value]??null)['sub_fields']??null;
				}, $value )
			);

			if( $activedSubFieldSets )
				return FieldSet::merge( ...$activedSubFieldSets );

			else
				return null;
		}
	}

}
