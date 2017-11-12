<?php

namespace CatPKT\AdminDelegation\Helpers;

use CatPKT\AdminDelegation as __;
use CatPKT\AdminDelegation\Exceptions as E;
use CatPKT\Encryptor as CPE;
use Symfony\Component\HttpFoundation\{  Request,  Response  };

////////////////////////////////////////////////////////////////

class HttpHandler
{

	/**
	 * Var encryptor
	 *
	 * @access protected
	 *
	 * @var    CPE\IEncryptor
	 */
	protected $encryptor;

	/**
	 * Var meta
	 *
	 * @access protected
	 *
	 * @var    Meta
	 */
	protected $meta;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  CPE\IEncryptor $encryptor
	 * @param  Meta $meta
	 */
	public function __construct( CPE\IEncryptor$encryptor, $meta )
	{
		$this->encryptor= $encryptor;
		$this->meta= $meta;
	}

	/**
	 * Method handle
	 *
	 * @access public
	 *
	 * @param  Request $request
	 *
	 * @return Response
	 */
	public function handle( Request$request ):Response
	{
		#
	}

}
