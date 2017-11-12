<?php

namespace CatPKT\AdminDelegation;

////////////////////////////////////////////////////////////////

/**
 * 资源接口
 *   通过委托后台管理的资源类继承此接口
 */
interface IResource
{

	/**
	 * 返回资源的ID
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return mixed
	 */
	function getId();

	/**
	 * 资源数据转化为数组
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return array
	 */
	function getData():array;

}
