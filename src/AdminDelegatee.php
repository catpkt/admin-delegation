<?php

namespace CatPKT\AdminDelegation;

use CatPKT\Encryptor as CPE;
use FenzHTTP\{  HTTP,  Request,  Response  };

////////////////////////////////////////////////////////////////

class AdminDelegatee
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
	 * Var uri
	 *
	 * @access protected
	 *
	 * @var    mixed
	 */
	protected $uri;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  CPE\IEncryptor $encryptor
	 * @param  mixed $delegatorUri
	 */
	public function __construct( CPE\IEncryptor$encryptor, $delegatorUri )
	{
		$this->encryptor= $encryptor;
		$this->uri= $delegatorUri;
	}

	/**
	 * Method getMeta
	 *
	 * @access public
	 *
	 * @return Meta
	 */
	public function getMeta():Meta
	{
		$response= $this->makeRequest( 'META' )->get();

		return $this->handleResponse( $response );
	}

	/**
	 * Method list
	 *
	 * @access public
	 *
	 * @param Helpers\Path $path
	 * @param int $take
	 * @param int $skip
	 * @param array $filters
	 *
	 * @return array
	 */
	public function list( Helpers\Path$path, int$take, int$skip=0, array$filters=[] ):array
	{
		$response= $this->makeRequest( 'LIST', $path, [ 'Take'=>$take, 'Skip'=>$skip, 'Filters'=>$filters, ] )->get();

		$data= $this->handleResponse( $response );

		$resourceMeta= $this->loadResourceMeta( $path );

		return array_map( function( $record )use( $resourceMeta ){  return new Helpers\Resource( $resourceMeta, $record['id'], $record['data'] );  }, $data );
	}

	/**
	 * Method count
	 *
	 * @access public
	 *
	 * @param Helpers\Path $path
	 * @param array $filters
	 *
	 * @return int
	 */
	public function count( Helpers\Path$path, array$filters=[] ):int
	{
		$response= $this->makeRequest( 'COUNT', $path, [ 'Filters'=>$filters, ] )->get();

		return $this->handleResponse( $response );
	}

	/**
	 * Method get
	 *
	 * @access public
	 *
	 * @param Helpers\Path $path
	 * @param mixed $id
	 *
	 * @return Helpers\Resource
	 */
	public function get( Helpers\Path$path, $id ):Helpers\Resource
	{
		$response= $this->makeRequest( 'GET', $path, [ 'Response-Id'=>$id, ] )->get();

		$record= $this->handleResponse( $response );

		$resourceMeta= $this->loadResourceMeta( $path );

		return new Helpers\Resource( $resourceMeta, $record['id'], $record['data'] );
	}

	/**
	 * Method create
	 *
	 * @access public
	 *
	 * @param Helpers\Path $path
	 * @param array $data
	 *
	 * @return mixed    资源ID
	 */
	public function create( Helpers\Path$path, array$data )
	{
		$response= $this->makeRequest( 'POST', $path )->post( ($this->encryptor)( $data ) );

		return $this->handleResponse( $response );
	}

	/**
	 * Method update
	 *
	 * @access public
	 *
	 * @param Helpers\Path $path
	 * @param mixed $id
	 * @param array $data
	 *
	 * @return bool
	 */
	public function update( Helpers\Path$path, $id, array$data ):bool
	{
		$response= $this->makeRequest( 'PATCH', $path, [ 'Response-Id'=>$id, ] )->patch( ($this->encryptor)( $data ) );

		return $this->handleResponse( $response );
	}

	/**
	 * Method delete
	 *
	 * @access public
	 *
	 * @param Helpers\Path $path
	 * @param mixed ...$ids
	 *
	 * @return int
	 */
	public function delete( Helpers\Path$path, ...$ids ):int
	{
		$response= $this->makeRequest( 'DELETE', $path, [ 'Response-Ids'=>$ids, ] )->delete();

		return $this->handleResponse( $response );
	}

	/**
	 * Method makeRequest
	 *
	 * @access protected
	 *
	 * @param  string $method
	 * @param  ?Helpers\Path $path
	 * @param  array $headers
	 *
	 * @return Request
	 */
	protected function makeRequest( string$method, Helpers\Path$path=null, array$headers=[] ):Request
	{
		$headers['Method']= $method;

		$path && $headers['Resource-Path']= $path;

		return HTTP::url( $this->uri )->header( 'Cat-Admin-Headers', ($this->encryptor)( $headers ) );
	}

	/**
	 * Method loadResourceMeta
	 *
	 * @access public
	 *
	 * @param  Helpers\Path $path
	 *
	 * @return Helpers\ResourceMeta
	 */
	public function loadResourceMeta( Helpers\Path$path ):Helpers\ResourceMeta
	{
		return $this->getMeta()->loadController( $path )[0];
	}

	/**
	 * Method handleResponse
	 *
	 * @access protected
	 *
	 * @param  Response $response
	 *
	 * @return viod
	 */
	protected function handleResponse( Response$response )
	{
		if( $response->status === 404 )
		{
			throw new Exceptions\NotFound();
		}
		else
		if( $response->status === 403 )
		{
			throw new Exceptions\ApiKeyUnpaired();
		}
		else
		if( $response->status >= 400 )
		{
			try{
				$e= $this->encryptor->decrypt( $response->body );
			}catch( CPE\DecryptException$e ){
				$e= $response->body;
			}

			throw new Exceptions\Unknown( $e );
		}

		try{
			return $this->encryptor->decrypt( $response->body );
		}
		catch( CPE\DecryptException$e )
		{
			throw new Exceptions\Unknown( $response->body );
		}
	}

	/**
	 * Method debugConnection
	 *
	 * @access public
	 *
	 * @return mixed
	 */
	public function debugConnection()
	{
		try{
			$this->getMeta();
		}
		catch( \Throwable$e )
		{
			return $e;
		}

		return null;
	}

}
