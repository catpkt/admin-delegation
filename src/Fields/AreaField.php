<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 地区 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class AreaField extends AField
{

	/**
	 * 设置选项标签
	 *
	 * @access public
	 *
	 * @param  string $label
	 *
	 * @return static
	 */
	public function optionLabel( string$label ):self
	{
		$this->rules['optionLabel']= $label;

		return $this;
	}

	/**
	 * 设置子字段集
	 *      在本字段勾选或不勾选时才填写
	 *
	 * @access public
	 *
	 * @param  FieldSet $trueFields   勾上时可用的 字段集
	 * @param  FieldSet $falseFields  不勾时可用的 字段集
	 *
	 * @return static
	 */
	public function subFields( FieldSet$trueFields=null, FieldSet$falseFields=null ):self
	{
		$this->rules['sub_fields']= [ $falseFields, $trueFields, ];

		return $this;
	}

}
