<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace cmf\controller;

use think\Controller;
use think\Request;
use think\View;
use think\Config;
use think\Container;

class BaseController extends Controller
{
    /**
     * 构造函数
     * @param Request $request Request对象
     * @access public
     */
    public function __construct()
    {
        $this->request = Container::get('request');

        if (!cmf_is_installed() && $this->request->module() != 'install') {
            header('Location: ' . cmf_get_root() . '/?s=install');
            exit;
        }

        $this->app = Container::get('app');
        $this->_initializeView();
        $this->view = Container::get('view')->init(
            $this->app['config']->pull('template')
        );

        // 控制器初始化
        $this->initialize();

        // 前置操作方法
        foreach ((array)$this->beforeActionList as $method => $options) {
            is_numeric($method) ?
                $this->beforeAction($options) :
                $this->beforeAction($method, $options);
        }
    }


    // 初始化视图配置
    protected function _initializeView()
    {
    }

    /**
     *  排序 排序字段为list_orders数组 POST 排序字段为：list_order
     */
    protected function listOrders($model)
    {
        if (!is_object($model)) {
            return false;
        }

        $pk  = $model->getPk(); //获取主键名称
        $ids = $this->request->post("list_orders/a");

        if (!empty($ids)) {
            foreach ($ids as $key => $r) {
                $data['list_order'] = $r;
                $model->where([$pk => $key])->update($data);
            }

        }

        return true;
    }


}