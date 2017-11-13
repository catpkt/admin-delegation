<?php

namespace CatPKT\AdminDelegation\Helpers;

use FenzHelpers\TGetter;
use CatPKT\AdminDelegation as __;

////////////////////////////////////////////////////////////////

class ResourceMeta implements IResourceMeta
{
	use TGetter;

	/**
	 * Var name
	 *
	 * @access protected
	 *
	 * @var    string
	 */
	protected $name;

	/**
	 * Var label
	 *
	 * @access protected
	 *
	 * @var    string
	 */
	protected $label;

	/**
	 * Var fields
	 *
	 * @access protected
	 *
	 * @var    __\Fields\FieldSet
	 */
	protected $fields;

	/**
	 * Var isStable
	 *
	 * @access protected
	 *
	 * @var    bool
	 */
	protected $isStable;

	/**
	 * Var forbiddenActions
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $forbiddenActions;

	/**
	 * Var subResources
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $subResources;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  AResourceController $controller
	 */
	public function __construct( __\AResourceController$controller )
	{
		$this->name=             $controller->name;
		$this->label=            $controller->label;
		$this->fields=           $controller->fields;
		$this->isStable=         $controller->isStable;
		$this->forbiddenActions= $controller->forbiddenActions;
		$this->subResources=     $controller->subResources;
	}

	/**
	 * Method getName
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getName():string
	{
		return $this->name;
	}

	/**
	 * Method getLabel
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getLabel():string
	{
		return $this->label;
	}

	/**
	 * Method getFields
	 *
	 * @access public
	 *
	 * @return __\Fields\FieldSet
	 */
	public function getFields():__\Fields\FieldSet
	{
		return $this->fields;
	}

	/**
	 * Method getIsStable
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function getIsStable():bool
	{
		return $this->isStable;
	}

	/**
	 * Method getForbiddenActions
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getForbiddenActions():array
	{
		return $this->forbiddenActions;
	}

	/**
	 * Method getSubResources
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getSubResources():array
	{
		return $this->subResources;
	}

}
