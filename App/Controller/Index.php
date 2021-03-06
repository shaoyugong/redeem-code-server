<?php
/**
 * Created by PhpStorm.
 * User: gongshaoyu
 * Date: 2017/2/8
 * Time: 11:51
 */

namespace App\Controller;


use App\Task;
use Core\AbstractInterface\AbstractController;
use Core\Component\Barrier;
use Core\Component\Logger;
use Core\Http\Message\Status;
use Core\Swoole\AsyncTaskManager;
use Core\Swoole\Server;
use Core\UrlParser;

class Index extends AbstractController
{
    function index()
    {
        // TODO: Implement index() method.
        $this->response()->withHeader("Content-type","text/html;charset=utf-8");
        $this->response()->write('
    <style type="text/css">
       *{ padding: 0; margin: 0; }
       div{ padding: 4px 48px;}
       body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px}
       h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; }
       p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}
    </style>
    <div style="padding: 24px 48px;">
        <h1>:)</h1><p>欢迎使用<b> easySwoole</b></p> 
        <span style="font-size:25px">从未如此之快 - 专为API而生的常驻内存型框架</span>
       <br/>
       <span style="font-size:20px">[ 欢迎前往 <a href="https://github.com/easy-swoole/easyswoole" target="easySwoole">GitHub</a> 为 easySwoole 赏一个Star ]</span>
   </div>
 ');/*  url:domain/index.html  domain/   domain  */
    }

    function onRequest($actionName)
    {
        // TODO: Implement onRequest() method.
    }

    function actionNotFound($actionName = null, $arguments = null)
    {
        // TODO: Implement actionNotFount() method.
        $this->response()->withStatus(Status::CODE_NOT_FOUND);
        $this->response()->write(file_get_contents(ROOT."/App/Static/404.html"));
    }

    function afterAction()
    {
        // TODO: Implement afterResponse() method.
    }
    function test(){
       $this->response()->write("this is test");
    }

    function test2(){
        $this->response()->write("this is test2");
    }
    function test3(){
        $this->response()->write("this is test2");
    }

    function shutdown(){
        Server::getInstance()->getServer()->shutdown();
    }
    function router(){
        $this->response()->write("your router not end");
    }

}