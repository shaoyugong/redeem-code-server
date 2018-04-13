<?php
/**
 * Created by PhpStorm.
 * User: gongshaoyu
 * Date: 2017/2/3
 * Time: 下午7:46
 */

namespace Core\AbstractInterface;


interface LoggerWriterInterface
{
    static function writeLog($obj,$logCategory,$timeStamp);
}