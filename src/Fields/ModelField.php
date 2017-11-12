<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 模型 字段
 *     后台实现者系统中的模型
 *
 * @method  showInList()   在列表中显示字段
 */
class StringField extends AField
{

	/**
	 * 设定模型类名
	 *
	 * @access public
	 *
	 * @param  string $class
	 *
	 * @return static
	 */
	public function length( string$class ):self
	{
		$this->rules['class']= $class;

		return $this;
	}

}
