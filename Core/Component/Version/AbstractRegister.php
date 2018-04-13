<?php
/**
 * Created by PhpStorm.
 * User: gongshaoyu
 * Date: 2017/11/22
 * Time: 下午9:58
 */

namespace Core\Component\Version;


abstract class AbstractRegister
{
    abstract function register(VersionList $versionList);
}