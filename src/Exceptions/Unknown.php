<?php

namespace CatPKT\AdminDelegation\Exceptions;

use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

class Unknown extends \Exception
{
	use TGetter;

	/**
	 * Var detail
	 *
	 * @access protected
	 *
	 * @var    mixed
	 */
	protected $detail;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  mixed $detail
	 */
	public function __construct( $detail )
	{
		$this->detail= $detail;
	}

	/**
	 * Method getDetail
	 *
	 * @access public
	 *
	 * @return mixed
	 */
	public function getDetail()
	{
		return $this->detail;
	}

}
