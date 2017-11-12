<?php

namespace CatPKT\AdminDelegation\Helpers;

use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

class Path
{
	use TGetter;

	/**
	 * Var target
	 *
	 * @access protected
	 *
	 * @var    string
	 */
	protected $target;

	/**
	 * Var path
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $path= [];

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  string $target
	 * @param  Resource $owner
	 */
	public function __construct( string$target, Resource$owner=null )
	{
		$this->target= $target;

		if( $owner )
		{
			$this->path= $owner->path->getPath();
			$this->addPath( $owner->resource, $owner->id );
		}
	}

	/**
	 * Method getTarget
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getTarget():string
	{
		return $this->target;
	}

	/**
	 * Method addPath
	 *
	 * @access public
	 *
	 * @param  string $resource
	 * @param  mixed $id
	 *
	 * @return viod
	 */
	public function addPath( string$resource, $id )
	{
		$this->path[]= [ $resource, $id, ];
	}

	/**
	 * Method getPath
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getPath():array
	{
		return $this->path;
	}

}
