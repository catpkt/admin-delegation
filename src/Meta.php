<?php

namespace CatPKT\AdminDelegation;

use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

/**
 * 元数据
 *   用于后台委托者向后台实现者描述后台中可管理的资源
 */
final class Meta implements \Serializable
{

	/**
	 * 添加资源控制器
	 *
	 * @access public
	 *
	 * @param  AResourceController $controller
	 *
	 * @return viod
	 */
	public function addResourceController( AResourceController$controller )
	{
		$this->controllers[$controller->name]= $controller;
	}

	/*\
	 * ┌┘
	 *─┤ 以上为后台委托者需要关心的部分
	 * └─────────────────────────────┘
	\*/

	use TGetter;

	/**
	 *
	 * Var controllers
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $controllers= [];

	/**
	 * Method getController
	 *
	 * @access public
	 *
	 * @param  string $name
	 *
	 * @return Helpers\IResourceMeta
	 *
	 * @throws Exceptions\NotFound
	 */
	public function getController( string$name ):Helpers\IResourceMeta
	{
		if(!( isset( $this->controllers[$name] ) ))
		{
			throw new Exceptions\NotFound();
		}

		return $this->controllers[$name];
	}

	/**
	 * Method getControllers
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getControllers():array
	{
		return $this->controllers;
	}

	/**
	 * Method loadController
	 *
	 * @access public
	 *
	 * @param  Helpers\Path $path
	 *
	 * @return [AResourceController,?IResource,]
	 */
	public function loadController( Helpers\Path$path ):array
	{
		$controller= $resource= null;

		foreach( $path->path as list( $name, $id, ) )
		{
			$controller= $controller? $controller->getSubResource( $name ) : $this->getController( $name );

			$id and $resource= $controller->get( $resource, $id );
		}

		$controller= $controller? $controller->getSubResource( $path->target ) : $this->getController( $path->target );

		return [ $controller, $resource, ];
	}

	/**
	 * Method serialize
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function serialize():string
	{
		return serialize(
			array_map(
				function( $controller )
				{
					return new Helpers\ResourceMeta( $controller );
				}
			,
				$this->controllers
			)
		);
	}

	/**
	 * Method serialize
	 *
	 * @final
	 *
	 * @access public
	 *
	 * @param string $serialized
	 *
	 * @return void
	 */
	public function unserialize( $serialized )
	{
		$this->controllers= unserialize( $serialized );
	}

}
