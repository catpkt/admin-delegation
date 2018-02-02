<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 组合 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class GroupField extends AField
{

	/**
	 * Method fields
	 *
	 * @access public
	 *
	 * @param  FieldSet $fields
	 *
	 * @return viod
	 */
	public function fields( FieldSet$fields )
	{
		$this->rules['fields']= $fields;
	}

}
