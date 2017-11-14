<?php

namespace CatPKT\AdminDelegation;

use Symfony\Component\HttpFoundation\{  Request,  Response  };

////////////////////////////////////////////////////////////////

/**
 * 后台委托者抽象类
 *
 * @abstract getEncryptor():\CatPKT\Encryptor\IEncryptor  提供 加密器
 * @abstract makeMeta():\CatPKT\AdminDelegation\Meta      提供 元数据
 *
 *
 * 本类提供了缓存策略，用于避免反复构造 Meta 。若要使用，覆盖下列方法即可。
 *
 * @overridable getVersion():string;                      元数据版本
 * @overridable cacheStore( string$cache );               存储缓存
 * @overridable cacheLoad():string;                       提取缓存
 *
 */
abstract class AAdminDelegator
{

	/**
	 * 控制器的单一入口
	 *
	 * @final
	 *
	 * @access public
	 *
	 * @param  Request $request
	 *
	 * @return Response
	 */
	final public function handle( Request$request ):Response
	{
		return (new Helpers\HttpHandler( $this->getEncryptor(), $this->getMeta() ))->handle( $request );
	}

	/**
	 * 加密器
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @return \CatPKT\Encryptor\IEncryptor
	 */
	abstract protected function getEncryptor():\CatPKT\Encryptor\IEncryptor;

	/**
	 * 元数据
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @return Meta
	 */
	abstract protected function makeMeta():\CatPKT\AdminDelegation\Meta;

	/**
	 * 元数据的版本
	 *   本库会对元数据进行缓存，若更新元数据，请更新版本号
	 *
	 * @overridable
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getVersion():string
	{
		return '0';
	}

	/**
	 * 存储缓存
	 *
	 * @overridable
	 *
	 * @access protected
	 *
	 * @param  string $cache
	 *
	 * @return viod
	 */
	protected function cacheStore( string$cache )
	{
		return ;
	}

	/**
	 * 提取缓存
	 *
	 * @overridable
	 *
	 * @access protected
	 *
	 * @return string
	 */
	protected function cacheLoad():string
	{
		return '';
	}

	/*\
	 * ┌┘
	 *─┤ 以上为后台委托者需要关心的部分
	 * └─────────────────────────────┘
	\*/

	/**
	 * Method getMeta
	 *
	 * @access private
	 *
	 * @return Meta
	 */
	private function getMeta():Meta
	{

		if(
			$version= $this->getVersion()
		and
			$cached= $this->loadFromCache()
		and
			($cached['version']??null) === $version
		and
			$cached['meta']??null
		and
			$cached['meta'] instanceof Meta
		){
			return $cached['meta'];
		}

		$new= $this->makeMeta();

		$version and $this->cache( $version, $new );

		return $new;
	}

	/**
	 * Method loadFromCache
	 *
	 * @access private
	 *
	 * @return array
	 */
	private function loadFromCache():array
	{
		try{
			$data= unserialize( $this->cacheLoad() );
		}
		catch( Throwable$e )
		{
			$data= false;
		}

		return is_array( $data )? $data : [];
	}

	/**
	 * Method cache
	 *
	 * @access private
	 *
	 * @param  string $version
	 * @param  Meta $meta
	 *
	 * @return viod
	 */
	private function cache( string$version, Meta$meta )
	{
		$this->cacheStore( serialize( [
			'version'=> $version,
			'meta'=> $meta,
		] ) );
	}

}
