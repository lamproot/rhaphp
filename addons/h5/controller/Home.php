<?php

namespace addons\h5\controller;


use app\common\controller\Addon;
use think\facade\Request;

class Home extends Addon
{
    public $isWexinLogin = false;
    public $onlyWexinOpen = false;

    public function index()
    {
        $this->assign('member', getMember());
        $this->fetch();
    }
}