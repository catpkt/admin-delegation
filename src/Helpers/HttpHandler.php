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
		$response= $this->handleByMethod( $headers['Method']??$request->getMethod(), $request );

		$response->headers->set( 'Access-Control-Allow-Origin', '*' );

		return $response;
	}

	/**
	 * Method handleByMethod
	 *
	 * @access private
	 *
	 * @param  string $method
	 * @param  Request $request
	 *
	 * @return Response
	 */
	private function handleByMethod( string$method, Request$request ):Response
	{
		$headers= $this->encryptor->decrypt( $request->headers->get( 'Cat-Admin-Headers' ) );

		$method= 'method_'.($headers['Method']??$request->getMethod());

		return (
			method_exists( $this, $method )
			? $this->{$method}( $headers, $request )
			: new Response( 'What are you doing?', 405 )
		);
	}

}
