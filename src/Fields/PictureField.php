<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 图片 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class PictureField extends AField
{

	/**
	 * Method size
	 *
	 * @access public
	 *
	 * @param  int $width
	 * @param  int $height
	 *
	 * @return static
	 */
	public function size( int$width, int$height ):self
	{
		$this->rules['size']= [ 'width'=>$width, 'height'=>$height, ];

		return $this;
	}

}
