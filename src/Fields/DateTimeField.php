<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 时间/日期 字段
 */
class DateTimeField extends AField
{

	/**
	 * 设为时间字段
	 *
	 * @access public
	 *
	 * @return viod
	 */
	public function asTime()
	{
		$this->rules['type']= 'time';

		return $this;
	}

	/**
	 * 设为 日期字段
	 *
	 * @access public
	 *
	 * @return viod
	 */
	public function asDate()
	{
		$this->rules['type']= 'date';

		return $this;
	}

	/**
	 * 同时设置起始时间和终止时间
	 *
	 * @access public
	 *
	 * @param  \DateTime $from
	 * @param  \DateTime $to
	 *
	 * @return static
	 */
	public function between( \DateTime$from, \DateTime$to ):self
	{
		if( $from <= $to )
		{
			$this->from( $from );
			$this->to( $to );
		}else{
			$this->from( $to );
			$this->to( $from );
		}

		return $this;
	}

	/**
	 * 设置起始时间
	 *
	 * @access public
	 *
	 * @param  \DateTime $from
	 *
	 * @return static
	 */
	public function from( \DateTime$from ):self
	{
		$this->rules['from']= $from;

		return $this;
	}

	/**
	 * 设置终止时间
	 *
	 * @access public
	 *
	 * @param  \DateTime $to
	 *
	 * @return static
	 */
	public function to( \DateTime$to ):self
	{
		$this->rules['to']= $to;

		return $this;
	}

}
