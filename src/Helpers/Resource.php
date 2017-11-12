<?php

namespace CatPKT\AdminDelegation\Helpers;

use CatPKT\AdminDelegation as __;
use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

class Resource implements __\IResource
{
	use TGetter;

	/**
	 * Var id
	 *
	 * @access protected
	 *
	 * @var    mixed
	 */
	protected $id;

	/**
	 * Var data
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $data;

	/**
	 * Var resource
	 *
	 * @access protected
	 *
	 * @var    ResourceMeta
	 */
	protected $resource;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  mixed $id
	 * @param  array $data
	 */
	public function __construct( ResourceMeta$resource, $id, array$data )
	{
		$this->resource= $resource;
		$this->id= $id;
		$this->data= $data;
	}

	/**
	 * 返回资源的ID
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * 资源数据转化为数组
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getData():array
	{
		return $this->data;
	}

}
