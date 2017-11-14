<?php

namespace CatPKT\AdminDelegation;

use FenzHelpers\TGetter;

////////////////////////////////////////////////////////////////

/**
 * 资源控制器
 *    用于委托者定义资源，并提供资源的控制权
 *
 * @abstract getName():string;                                                                                                  资源名称
 * @abstract getLabel():string;                                                                                                 资源的中文名字
 * @abstract getFields():\CatPKT\AdminDelegation\Fields\FieldSet;                                                               资源字段
 * @abstract getIsStable():bool;                                                                                                是否为稳定资源
 * @abstract list( \CatPKT\AdminDelegation\IResource$owner=null, int$limit, int$offset=0, array$filters=[] ):array;             按条件列出资源
 * @abstract get( \CatPKT\AdminDelegation\IResource$owner=null, $id ):\CatPKT\AdminDelegation\IResource;                        获取单个资源
 * @abstract create( \CatPKT\AdminDelegation\IResource$owner=null, array$data );                                                创建新资源
 * @abstract update( \CatPKT\AdminDelegation\IResource$owner=null, $id, array$data ):\CatPKT\AdminDelegation\Results\AResult;   更新资源
 * @abstract delete( \CatPKT\AdminDelegation\IResource$owner=null, ...$id ):int;                                                批量删除资源
 * @overridable getForbiddenActions():array                     禁止的操作
 *
 * @method setSubResource( self$subResource ):self              添加子资源
 */
abstract class AResourceController implements Helpers\IResourceMeta
{

	/**
	 * 获取资源名称
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return string
	 */
	abstract public function getName():string;

	/**
	 * 获取资源的中文名字
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return string
	 */
	abstract public function getLabel():string;

	/**
	 * 定义资源字段
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return Fields\FieldSet
	 */
	abstract public function getFields():\CatPKT\AdminDelegation\Fields\FieldSet;

	/**
	 * 是否为稳定资源
	 *     稳定资源即只在委托后台一个地方进行改变，不会自行变动的资源
	 *     后台实现者可进行缓存
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return bool
	 */
	abstract public function getIsStable():bool;

	/**
	 * 按条件列出资源
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  ?\CatPKT\AdminDelegation\IResource $owner  父资源
	 * @param  int $limit         获取数量
	 * @param  int $offset        从第几个开始
	 * @param  array $filters     过滤规则
	 *
	 * @return [...\CatPKT\AdminDelegation\IResource,]    资源列表
	 */
	abstract public function list( \CatPKT\AdminDelegation\IResource$owner=null, int$limit, int$offset=0, array$filters=[] ):array;

	/**
	 * 按条件统计资源
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  ?\CatPKT\AdminDelegation\IResource $owner  父资源
	 * @param  array $filters     过滤规则
	 *
	 * @return int                资源数量
	 */
	abstract public function count( \CatPKT\AdminDelegation\IResource$owner=null, array$filters=[] ):int;

	/**
	 * 获取单个资源
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  ?\CatPKT\AdminDelegation\IResource $owner  父资源
	 * @param  mixed $id          主键
	 *
	 * @return \CatPKT\AdminDelegation\IResource          资源对象
	 *
	 * @throws Exceptions\NotFound  资源不存在时抛此异常 将返回404
	 */
	abstract public function get( \CatPKT\AdminDelegation\IResource$owner=null, $id ):\CatPKT\AdminDelegation\IResource;

	/**
	 * 创建新资源
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  ?\CatPKT\AdminDelegation\IResource $owner  父资源
	 * @param  array $data        资源数据
	 *
	 * @return mixed              新资源ID
	 *
	 * @throws Exceptions\ValidateFailed  数据验证不通过时抛此异常
	 */
	abstract public function create( \CatPKT\AdminDelegation\IResource$owner=null, array$data );

	/**
	 * 更新资源
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  ?\CatPKT\AdminDelegation\IResource $owner  父资源
	 * @param  mixed $id
	 * @param  array $data
	 *
	 * @return bool               是否有改动 [false 代表数据无变动，不代表更新失败，失败应抛出异常]
	 *
	 * @throws Exceptions\ValidateFailed  数据验证不通过时抛此异常
	 */
	abstract public function update( \CatPKT\AdminDelegation\IResource$owner=null, $id, array$data ):bool;

	/**
	 * 删除/批量删除资源
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  ?\CatPKT\AdminDelegation\IResource $owner  父资源
	 * @param  mixed ...$ids
	 *
	 * @return int                成功删除的数据条数
	 */
	abstract public function delete( \CatPKT\AdminDelegation\IResource$owner=null, ...$ids ):int;

	/**
	 * 可用的操作
	 *
	 * @access
	 *
	 * @const    mixed
	 */
	const ACTIONS= [ 'list', 'get', 'create', 'update', 'delete', 'batch_delete', ];

	/**
	 * 禁止的操作
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getForbiddenActions():array
	{
		return [];
	}

	/**
	 * 添加子资源控制器
	 *
	 * @access public
	 *
	 * @param  self ...$subResources
	 *
	 * @return void
	 */
	final public function setSubResource( self...$subResources )
	{
		foreach( $subResources as $subResource )
		{
			$this->subResources[$subResource->name]= $subResource;
		}
	}

	/*\
	 * ┌┘
	 *─┤ 以上为后台委托者需要关心的部分
	 * └─────────────────────────────┘
	\*/

	use TGetter;

	/**
	 * Var subResources
	 *
	 * @access private
	 *
	 * @var    array
	 */
	private $subResources= [];

	/**
	 * 获取子资源控制器
	 *
	 * @access public
	 *
	 * @param  string $name
	 *
	 * @return static
	 */
	final public function getSubResource( string$name ):self
	{
		if(!( isset( $this->subResources[$name] ) ))
		{
			throw new Exceptions\NotFound();
		}

		return $this->subResources[$name];
	}

	/**
	 * 获取所有子资源控制器
	 *
	 * @access public
	 *
	 * @return static
	 */
	final public function getSubResources():array
	{
		return $this->subResources;
	}

}
