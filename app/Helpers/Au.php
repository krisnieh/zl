<?php

namespace App\Helpers;

use App\User;

/**
 * 权限 
 *
 */
class Au
{
    private $auth;

    private $role;

    function __construct()
    {
        $this->auth = json_decode(User::find(session('id'))->auth);
        $this->role = [
            'staff' => "众乐速配",
            'agent' => "代理商",
            'salesman' => "代理商员工",
            'customer' => "客户",
        ];
    }

    // 目标权限
    private function targetAuth($id)
    {
        $target = User::find($id);

        if(!$target) return false;

        return json_decode($target->auth);
    }

    // root 用户
    public function root($id=0)
    {
        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('root', $use) && $use->root ? true : false;
    }

    // admin 管理员
    public function admin($id=0)
    {
        if($this->root($id)) return true;

        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('admin', $use) && $use->admin ? true : false;
    }

    // manager 操作员
    public function manager($id=0)
    {
        if($this->admin($id)) return true;

        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('manager', $use) && $use->manager ? true : false;
    }

    // own 自己
    public function own($id)
    {
        return session('id') == $id;
    }

    // creator 创造者
    public function creator($id)
    {
        return User::find(session('id'))->parent_id == $id;
    }

    // 有管理权
    public function control($id)
    {
        if($this->own($id)) return false;

        if($this->root()) return true;
        if($this->admin() && !$this->admin($id)) return true;
        if($this->manager() && !$this->manager($id)) return true;

        return false;
    }

    // 锁定
    public function locked($id=0)
    {
        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('locked', $use) && $use->locked ? true : false;
    }

    // 内部
    public function staff($id=0)
    {
        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('type', $use) && $use->type == 'staff' ? true : false;
    }

    // 代理
    public function agent($id=0)
    {
        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('type', $use) && $use->type == 'agent' ? true : false;
    }

    // 代理推销员
    public function salesman($id=0)
    {
        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('type', $use) && $use->type == 'salesman' ? true : false;
    }

    // 客户
    public function customer($id=0)
    {
        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('type', $use) && $use->type == 'customer' ? true : false;
    }

    // 类别名
    public function type($id=0)
    {
        $use = $id === 0 ? $this->auth : $this->targetAuth($id);

        if(!$use) return false;

        return array_key_exists('type', $use) && array_key_exists($use->type, $this->role) ? $this->role[$use->type] : '未授权';
    }

}













