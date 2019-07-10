<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------


namespace app\miniapp\controller;


use app\common\model\MiniappAddon;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\Validate;


class App extends Base
{

    private $addonCfByDb;
    private $addonCfByFile;

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $name = input('name');
        $model = new MiniappAddon();
        $addon = $model->where(['addon' => $name])->find();
        if (empty($addon)) {
            $this->error('应用不存在');
        }
        $this->addonCfByDb = $addonCfByDb = $model->where(['addon' => $name, 'status' => 1])->find();
        $this->addonCfByFile = $addonCfByFile = $model->getAddonByFile($name);
        if ($addonCfByDb['addon'] != $addonCfByFile['addon']) {
            $this->error('应用信息不相符，请检查');
        }
        $addonMenu = isset($addonCfByFile['menu']) ? $addonCfByFile['menu'] : '';
        $node=input('node');
        if (!empty($addonMenu) && is_array($addonMenu)) {
            foreach ($addonMenu as $key=>$val){
                $addonMenu[$key]['show']=0;
                $addonMenu[$key]['show'] = 0;
                $addonMenu[$key]['url'] = str_replace('/', '_', $val['url']);
                if ($node == $addonMenu[$key]['url'] && !empty($node)) {
                    $addonMenu[$key]['show'] = 1;
                }
                if(isset($val['child']) && !empty($val['child']) && is_array($val['child'])){
                    foreach ($val['child'] as $k=>$v){
                        if($node==$addonMenu[$key]['url']=str_replace('/','_',$v['url'])){
                            $addonMenu[$key]['show']=1;
                        }
                        $addonMenu[$key]['child'][$k]['url']=str_replace('/','_',$v['url']);
                    }
                }
            }
        }
        $this->assign('node',$node);
        $this->assign('addonMenu', $addonMenu);
        $this->assign('addonInfo', $addonCfByDb);
        $this->assign('name', $name);
        $this->assign('menu_app', '');

    }

    /**
     * 参数配置
     * @author Geeson  314835050@qq.com
     * @param string $name
     * @return \think\response\View
     */
    public function config($name = '')
    {
        if (Request::isPost()) {
            $input = input('post.');
            $data['mpid'] = $this->_mid;
            $data['addon'] = $input['addonName'];
            $data['infos'] = json_encode($input);
            $result = Db::name('miniapp_addon_info')->where(['mpid' => $this->_mid, 'addon' => $input['addonName']])->find();
            if (empty($result)) {
                $res = Db::name('miniapp_addon_info')->insert($data);
            } else {
                $res = Db::name('miniapp_addon_info')->where(['mpid' => $this->_mid, 'addon' => $input['addonName']])->update(['infos' => json_encode($input)]);
            }
            ajaxMsg(1, '配置成功');

        } else {
            $result = Db::name('miniapp_addon_info')->where(['mpid' => $this->_mid, 'addon' => $name])->find();
            $addonConfigByMp = json_decode($result['infos'], true);
            $config = json_decode($this->addonCfByDb['config'], true);
            if (!empty($addonConfigByMp) && !empty($config) && is_array($config)) {
                foreach ($config as $key1 => $val1) {
                    foreach ($addonConfigByMp as $name => $val2) {
                        if ($val1['name'] == $name) {
                            $config[$key1] = $val1;
                            if ($val1['type'] == 'radio') {
                                foreach ($val1['value'] as $key3 => $val3) {
                                    if ($val3['value'] == $val2) {
                                        $config[$key1]['value'][$key3]['checked'] = 1;
                                    } else {
                                        $config[$key1]['value'][$key3]['checked'] = 0;
                                    }
                                }
                            } elseif ($val1['type'] == 'checkbox') {
                                foreach ($val1['value'] as $key3 => $val3) {
                                    foreach ($val2 as $key4 => $val4) {
                                        if ($val3['name'] == $key4) {
                                            $config[$key1]['value'][$key3]['checked'] = 1;
                                            break;
                                        } else {
                                            $config[$key1]['value'][$key3]['checked'] = 0;
                                        }
                                    }
                                }
                            } elseif ($val1['type'] == 'select') {
                                foreach ($val1['value'] as $key3 => $val3) {
                                    if ($val3['value'] == $val2) {
                                        $config[$key1]['value'][$key3]['selected'] = 1;
                                    } else {
                                        $config[$key1]['value'][$key3]['selected'] = 0;
                                    }
                                }
                            } else {
                                $config[$key1]['value'] = $val2;
                            }
                        }
                    }
                }
            }
            $this->assign('miniapi', Request::domain() .Request::root(). '/api/' . $this->_mid . '/');
            $this->assign('config', $config);
            return view();
        }
    }

    public function toView($node)
    {
        $node=str_replace('_','/',$node);
        $url = addonUrl($node, ['_mid' => $this->_mid]);
        $this->assign('url', $url);
        return view('view');
    }


}