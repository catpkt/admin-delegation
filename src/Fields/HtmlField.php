<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 富文本 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class HtmlField extends AField
{

	/**
	 * Method isComplex
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function isComplex():bool
	{
		return true;
	}

}
