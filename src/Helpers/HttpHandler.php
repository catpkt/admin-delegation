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
	 * @param  __\Meta $meta
	 */
	public function __construct( CPE\IEncryptor$encryptor, __\Meta$meta )
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
		try{
			$response= $this->handleByMethod( $headers['Method']??$request->getMethod(), $request );
		}
		catch( E\NotFound$e )
		{
			return new Response( 'What you are looking for is not exists.', 404 );
		}
		catch( CPE\DecryptException$e )
		{
			return new Response( 'You are not welcome. Just go away.', 403 );
		}
		catch( E\ValidateFailed$e )
		{
			return new Response( ($this->encryptor)( $e->getErrors() ), 422 );
		}
		catch( CPE\EncryptException$e )
		{
			return new Response( 'Crying.', 555 );
		}
		catch( \Throwable$e )
		{
			return new Response( ($this->encryptor)( [
				'exception'=> get_class( $e ),
				'message'=> $e->getMessage(),
				'code'=> $e->getCode(),
				'file'=> $e->getFile(),
				'line'=> $e->getLine(),
				'trace'=> array_map( function( $trace ){  unset( $trace['args'] );  return $trace;  }, $e->getTrace() ),
			] ), 500 );
		}

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

	/**
	 * Method method_META
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_META( array$headers, Request$request ):Response
	{
		return new Response( ($this->encryptor)( $this->meta ) );
	}

	/**
	 * Method method_LIST
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_LIST( array$headers, Request$request ):Response
	{
		list( $controller, $resource, )= $this->meta->loadController( $headers['Resource-Path'] );

		$list= $controller->list( $resource, $headers['Take']??16, $headers['Skip']??0, $headers['Filters']??[] );

		foreach( $list as $key=>$resource )
		{
			if(!( $resource instanceof __\IResource ))
			{
				throw new \TypeError( 'Return value of '.get_class( $controller ).'->list() must be an array of instances of '.__\IResource::class.', strange things returned' );
			}

			$list[$key]= [ 'id'=>$resource->getId(), 'data'=>$resource->getData(), ];
		}

		return new Response( ($this->encryptor)( $list ) );
	}

	/**
	 * Method method_COUNT
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_COUNT( array$headers, Request$request ):Response
	{
		list( $controller, $resource, )= $this->meta->loadController( $headers['Resource-Path'] );

		$count= $controller->count( $resource, $headers['Filters']??[] );

		return new Response( ($this->encryptor)( $count ) );
	}

	/**
	 * Method method_GET
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_GET( array$headers, Request$request ):Response
	{
		list( $controller, $resource, )= $this->meta->loadController( $headers['Resource-Path'] );

		$resource= $controller->get( $resource, $headers['Response-Id'] );

		return new Response( ($this->encryptor)( [ 'id'=>$resource->getId(), 'data'=>$resource->getData(), ] ) );
	}

	/**
	 * Method method_POST
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_POST( array$headers, Request$request ):Response
	{
		list( $controller, $resource, )= $this->meta->loadController( $headers['Resource-Path'] );

		$result= $controller->create( $resource, $this->encryptor->decrypt( $request->getContent() ) );

		return new Response( ($this->encryptor)( $result ) );
	}

	/**
	 * Method method_PATCH
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_PATCH( array$headers, Request$request ):Response
	{
		list( $controller, $resource, )= $this->meta->loadController( $headers['Resource-Path'] );

		$result= $controller->update( $resource, $headers['Response-Id'], $this->encryptor->decrypt( $request->getContent() ) );

		return new Response( ($this->encryptor)( $result ) );
	}

	/**
	 * Method method_DELETE
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_DELETE( array$headers, Request$request ):Response
	{
		list( $controller, $resource, )= $this->meta->loadController( $headers['Resource-Path'] );

		$result= $controller->delete( $resource, ...$headers['Response-Ids'] );

		return new Response( ($this->encryptor)( $result ) );
	}

	/**
	 * Method method_OPTIONS
	 *
	 * @access protected
	 *
	 * @param  array $headers
	 * @param  Request $request
	 *
	 * @return Response
	 */
	protected function method_OPTIONS( array$headers, Request$request ):Response
	{
		$response= new Response();

		$methods= 'GET, POST, PATCH, DELETE, OPTIONS';

		$response->headers->set( 'Allow', $methods );
		$response->headers->set( 'Access-Control-Allow-Methods', $methods );

		return $response;
	}

}
