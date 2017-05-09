<?php
/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/5/1
 * Time: 11:55
 */

namespace Superwechat\Lib;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class Log
{
    /**
     * @var LoggerInterface
     */
    protected static $logger;

    /**
     * Call static no exists method
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        //TODO: Implement __callStatic() method.
        return forward_static_call_array([self::getLogger(),$method], $arguments);
    }

    /**
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    /**
     * Get Logger
     *
     * @return Logger
     */
    public static function getLogger()
    {
        return self::$logger ? self::$logger : self::$logger = self::createDefaultLogger();
    }

    /**
     * Create Default Logger
     *
     * @return Logger
     */
    public static function createDefaultLogger()
    {
        $log = new Logger('SupperWechat');
        return $log;
    }
}