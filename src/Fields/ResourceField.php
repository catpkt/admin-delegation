<?php

namespace CatPKT\AdminDelegation\Fields;

use CatPKT\AdminDelegation as __;

////////////////////////////////////////////////////////////////

/**
 * 资源 字段
 *
 * @method  showInList()   在列表中显示字段
 */
class ResourceField extends AField
{

	/**
	 * Method path
	 *
	 * @access public
	 *
	 * @param  string $path
	 *
	 * @return static
	 */
	public function path( string$path ):self
	{
		$this->rules['path']= $path;

		return $this;
	}

	/**
	 * 设置标签字段
	 *
	 * @access public
	 *
	 * @param  string $field
	 *
	 * @return static
	 */
	public function labelField( string$field ):self
	{
		$this->rules['label_field']= $field;

		return $this;
	}

	/**
	 * Method load
	 *
	 * @access public
	 *
	 * @param  __\AdminDelegatee $delegatee
	 * @param  __\Helpers\Path $path
	 * @param  mixed $id
	 *
	 * @return __\IResource
	 */
	public function load( __\AdminDelegatee$delegatee, __\Helpers\Path$path, $id ):__\IResource
	{
		return $delegatee->get( $this->makePath( $path ), $id );
	}

	/**
	 * Method getOptions
	 *
	 * @access public
	 *
	 * @param  __\AdminDelegatee $delegatee
	 * @param  __\Helpers\Path $path
	 *
	 * @return array
	 */
	public function getOptions( __\AdminDelegatee$delegatee, __\Helpers\Path$path ):array
	{
		return array_column(
			array_map(
				function( __\IResource$resource ){
					return [
						'id'=> $resource->id,
						'label'=> $resource->{$this->rules['label_field']??'id'},
					];
				}
			,
				$delegatee->list( $this->makePath( $path ), 128 )
			)
		,
			'label'
		,
			'id'
		);
	}

	/**
	 * Method makePath
	 *
	 * @access protected
	 *
	 * @param  __\Helpers\Path $path
	 *
	 * @return __\Helpers\Path
	 */
	protected function makePath( __\Helpers\Path$path ):__\Helpers\Path
	{
		$paths= explode( '/', $this->rules['path'] );

		$target= array_pop( $paths );

		foreach( $paths as $value )
		{
			switch( $value )
			{
				case '..':{
					$path= $path->super();
				}break;

				case '.':{
					continue;
				}break;

				case '':{
					$path= new __\Helpers\Path( $target );
				}break;

				default:{
					$path->addPath( ...explode( ':', $value ) );
				}break;
			}
		}

		return $path->changeTarget( $target );
	}

}
