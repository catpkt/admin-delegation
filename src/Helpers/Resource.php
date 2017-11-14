<?php

namespace CatPKT\AdminDelegation\Helpers;

use CatPKT\AdminDelegation as __;

////////////////////////////////////////////////////////////////

class Resource implements __\IResource, \ArrayAccess
{

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

	/**
	 * Method __toString
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function __toString():string
	{
		return $this->id;
	}

	/**
	 * Method __get
	 *
	 * @access public
	 *
	 * @param  string $property
	 *
	 * @return mixed
	 */
	public function __get( string$property )
	{
		return $this->offsetGet( $property );
	}

	/**
	 * Method offsetExists
	 *
	 * @access public
	 *
	 * @param  string $offset
	 *
	 * @return bool
	 */
	public function offsetExists( $offset ):bool
	{
		if( 'id'===$offset ) return true;

		return array_key_exists( $offset, $this->data );
	}

	/**
	 * Method offsetGet
	 *
	 * @access public
	 *
	 * @param  string $offset
	 *
	 * @return mixed
	 */
	public function offsetGet( $offset )
	{
		if( 'id'===$offset ) return $this->id;

		return $this->data[$offset]??null;
	}

	/**
	 * Method offsetSet
	 *
	 * @access public
	 *
	 * @param  string $offset
	 * @param  mixed $value
	 *
	 * @return viod
	 */
	public function offsetSet( $offset, $value )
	{
		$this->data[$offset]= $value;
	}

	/**
	 * Method offsetUnset
	 *
	 * @access public
	 *
	 * @param  string $offset
	 *
	 * @return viod
	 */
	public function offsetUnset( $offset )
	{
		unset( $this->data[$offset] );
	}

}
