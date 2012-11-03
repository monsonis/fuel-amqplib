<?php

namespace Amqplib;

/**
 *
 * Example:
 *
 * <code>
 * $conn = Amqplib_Fuel::connection();
 * </code>
 *
 * Or to use a defined connection other than 'default'
 * <code>
 * $conn = Amqplib_Fuel::connection('connection_name');
 * </code>
 *
 */

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Amqplib
{
	/** @var array */
	protected static $connections;

	/** @var array */
	protected static $settings;

	/**
	 * Carga la condiguración
	 * @return [type] [description]
	 */
	public static function _init()
	{
		\Config::load('amqplib', true);
		static::$settings = \Config::get('amqplib');
		static::$connections = array();
	}

	/**
	 * @return PhpAmqpLib\Connection\AMQPConnection
	 */
	public static function connection($connnection = 'default')
	{
		if ( ! isset(static::$connections[$connnection]))
		{
			static::_init_connection($connnection);
		}
		return static::$connections[$connnection];
	}

	/**
	 * @return PhpAmqpLib\Message\AMQPMessage
	 */
	public static function message($body = '', $properties = null)
	{
		return new AMQPMessage($body, $properties);
	}

	/**
	 * [_init_connection description]
	 * @param  [type] $connnection [description]
	 * @return [type]              [description]
	 */
	protected static function _init_connection($connnection)
	{
		$settings = static::$settings;

		if ( ! isset($settings[$connnection]))
		{
			throw new \Exception('No connection configuration for '.$connnection);
		}

		static::$connections[$connnection] = new AMQPConnection(
			$settings[$connnection]['host'], $settings[$connnection]['port'],
			$settings[$connnection]['user'], $settings[$connnection]['pass'],
			$settings[$connnection]['vhost']);

		if ( ! empty($settings[$connnection]['debug']))
		{
			define('AMQP_DEBUG', true);
		}
	}

}
