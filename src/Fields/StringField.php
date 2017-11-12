<?php

namespace CatPKT\AdminDelegation\Fields;

////////////////////////////////////////////////////////////////

/**
 * 字符串 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class StringField extends AField
{

	/**
	 * 设定长度验证
	 *
	 * @access public
	 *
	 * @param  int $max
	 * @param  int $min
	 *
	 * @return static
	 */
	public function length( int$max, int$min=0 ):self
	{
		$this->rules['length']= [ 'max'=>$max, 'min'=>$min, ];

		return $this;
	}

	/**
	 * 设定正则验证
	 *
	 * @access public
	 *
	 * @param  string $pattern
	 *
	 * @return static
	 */
	public function pattern( string$pattern ):self
	{
		$this->rules['pattern']= $pattern;

		return $this;
	}

	/**
	 * 设为 URL 字段
	 *
	 * @access public
	 *
	 * @return static
	 */
	public function asUrl():self
	{
		$this->rules['type']= 'url';

		return $this;
	}

	/**
	 * 设为 电话号码 字段
	 *
	 * @access public
	 *
	 * @return static
	 */
	public function asTel():self
	{
		$this->rules['type']= 'tel';

		return $this;
	}

	/**
	 * 设为 Email 字段
	 *
	 * @access public
	 *
	 * @return static
	 */
	public function asEmail():self
	{
		$this->rules['type']= 'tel';

		return $this;
	}

	/**
	 * 设为多行 (与 asUrl, asTel, asEmail 互斥)
	 *
	 * @access public
	 *
	 * @param  bool $multiLine
	 *
	 * @return static
	 */
	public function multiLine( bool$multiLine=true ):self
	{
		$this->rules['type']= 'multi_line_string';

		return $this;
	}

}
