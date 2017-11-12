<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 数字 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class StringField extends AField
{

	/**
	 * Method max
	 *
	 * @access public
	 *
	 * @param  float $max
	 *
	 * @return static
	 */
	public function max( float$max ):self
	{
		$this->rules['max']= $max;

		return $this;
	}

	/**
	 * Method min
	 *
	 * @access public
	 *
	 * @param  float $min
	 *
	 * @return static
	 */
	public function min( float$min ):self
	{
		$this->rules['min']= $min;

		return $this;
	}

	/**
	 * Method step
	 *
	 * @access public
	 *
	 * @param  float $step
	 *
	 * @return static
	 */
	public function step( float$step ):self
	{
		$this->rules['step']= $step;

		return $this;
	}

}
