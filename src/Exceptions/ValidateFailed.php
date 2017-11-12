<?php

namespace CatPKT\AdminDelegation\Exceptions;

////////////////////////////////////////////////////////////////

class ValidateFailed extends \Exception
{

	/**
	 * Var errors
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $errors;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  array $errors
	 */
	public function __construct( array$errors )
	{
		$errors and $this->setErrors( $errors );
	}

	/**
	 * 批量设置错误信息
	 *
	 * @access public
	 *
	 * @param  array $errors
	 *
	 * @return static
	 */
	public function setErrors( array$errors ):self
	{
		foreach( $errors as $field=>$error )
		{
			$this->setError( $field, $error );
		}

		return $this;
	}

	/**
	 * 设置错误信息
	 *
	 * @access public
	 *
	 * @param  string $field
	 * @param  string $error
	 *
	 * @return static
	 */
	public function setError( string$field, string$error ):self
	{
		$this->errors[$field][]= $error;

		return $this;
	}

	/**
	 * Method getErrors
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getErrors():array
	{
		return $this->errors;
	}

}
