<?php

namespace addons\cms\controller;

use addons\cms\model\Archives;

/**
 * 搜索控制器
 * Class Search
 * @package addons\cms\controller
 */
class Search extends Base
{
    public function index()
    {
        $search = $this->request->request("search");

        $filterlist = [];
        $orderlist = [];

        $orderby = $this->request->get('orderby', '');
        $orderway = $this->request->get('orderway', '', 'strtolower');
        $params = ['search' => $search];
        if ($orderby) {
            $params['orderby'] = $orderby;
        }
        if ($orderway) {
            $params['orderway'] = $orderway;
        }

        $sortrank = [
            ['name' => 'default', 'field' => 'weigh', 'title' => __('Default')],
            ['name' => 'views', 'field' => 'views', 'title' => __('Views')],
            ['name' => 'id', 'field' => 'id', 'title' => __('Post date')],
        ];

        $orderby = $orderby && in_array($orderby, ['default', 'id', 'views']) ? $orderby : 'default';
        $orderway = $orderway ? $orderway : 'desc';
        foreach ($sortrank as $k => $v) {
            $url = '?' . http_build_query(array_merge($params, ['orderby' => $v['name'], 'orderway' => ($orderway == 'desc' ? 'asc' : 'desc')]));
            $v['active'] = $orderby == $v['name'] ? true : false;
            $v['orderby'] = $orderway;
            $v['url'] = $url;
            $orderlist[] = $v;
        }
        $orderby = $orderby == 'default' ? 'weigh' : $orderby;

        $pagelist = Archives
            ::where('status', 'normal')
            ->whereNull('deletetime')
            ->where('title', 'like', "%{$search}%")
            ->order($orderby, $orderway)
            ->paginate(10, false, ['type' => '\\addons\\cms\\library\\Bootstrap']);
        $pagelist->appends($params);
        $this->view->assign("__FILTERLIST__", $filterlist);
        $this->view->assign("__ORDERLIST__", $orderlist);
        $this->view->assign("__PAGELIST__", $pagelist);
        \think\Config::set('cms.title', __("Search for %s", $search));
        return $this->view->fetch('/search');
    }

    public function typeahead()
    {
        $search = $this->request->post("search");
        $list = Archives
            ::where('status', 'normal')
            ->where('title', 'like', "%{$search}%")
            ->order('id', 'desc')
            ->field('id,title,diyname,channel_id,likes,dislikes,tags,createtime')
            ->limit(10)
            ->select();
        $result = collection($list)->toArray();
        $result[] = ['id' => 0, 'title' => __('Search more %s', $search), 'url' => addon_url("cms/search/index", [':search' => $search, 'search' => $search])];
        return json($result);
    }
}
