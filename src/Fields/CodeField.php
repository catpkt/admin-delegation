<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 代码 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class CodeField extends AField
{

	/**
	 * 设定长度验证
	 *
	 * @access public
	 *
	 * @param  string $language
	 *
	 * @return static
	 */
	public function language( string$language ):self
	{
		$this->rules['language']= $language;

		return $this;
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

}
