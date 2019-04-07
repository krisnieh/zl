<?php

namespace App\Helpers;

use Auth;

use App\User;
use App\Org;


/**
 * 授权 
 *
 */
class Role
{
    public function show($json, $key) 
    {
        $arr = json_decode($json);
        return $arr && array_key_exists($key, $arr) ? $arr->$key : null;
    }

    // 个人信息
    public function me()
    {
        return json_decode(Auth::user()->info);
    }

    // 存在并且为为true
    private function hasAndTrue($json, $key) 
    {
        $arr = json_decode($json);
        return $arr && array_key_exists($key, $arr) && $arr->$key == true ? true : false;
    }

    // 选择目标
    private function choose($id=0)
    {
        if (!Auth::check() && $id==0) abort('403');
        return $id == 0 ? Auth::user() : User::findOrFail($id);
    }

    /**
     * 账号锁定
     *
     */
    public function locked($id=0)
    {
        return $this->hasAndTrue($this->choose($id)->auth, 'locked');
    }

    /**
     * 机构锁定
     *
     */
    public function orgLocked($id=0)
    {
        return $this->hasAndTrue($this->choose($id)->org->auth, 'locked');
    }

    /**
     * root : 超级管理员
     *
     */
    public function root($id=0)
    {
        if(!$this->staff($id)) return false;

        return $this->hasAndTrue($this->choose($id)->auth, 'root');
    }

    /**
     * admin : 管理员
     *
     */
    public function admin($id=0)
    {
        if($this->root($id)) return true;

        return $this->hasAndTrue($this->choose($id)->auth, 'admin');
    }

    /**
     * manager : 经理
     *
     */
    public function manager($id=0)
    {
        if($this->admin($id)) return true;
        
        return $this->hasAndTrue($this->choose($id)->auth, 'manager');
    }

    /**
     * master : 代理商管理员
     *
     */
    public function master($id=0)
    {
        if(!$this->angent($id) && !$this->customer($id)) return false;
        
        return $this->hasAndTrue($this->choose($id)->auth, 'master');
    }

    /**
     * staff : 本单位
     *
     */
    public function staff($id=0)
    {
        return $this->choose($id)->org->typeConf->key == 'staff';
    }

    /**
     * angent : 代理商
     *
     */
    public function angent($id=0)
    {
        return $this->choose($id)->org->typeConf->key == 'angent';
    }

    /**
     * customer : 客户
     *
     */
    public function customer($id=0)
    {
        return $this->choose($id)->org->typeConf->key == 'customer';
    }

    /**
     * 自己
     *
     */
    public function own($id)
    {
        return Auth::id() == $id;
    }

    /**
     * 同一机构
     *
     */
    public function sameOrg($id)
    {
        return Auth::user()->org_id == User::findOrFail($id)->org_id;
    }


    /**
     * 机构指定管理员
     *
     */
    public function orgMaster($org_id)
    {
        return Auth::id() == Org::findOrFail($org_id)->parent_id;
    }

    /**
     * 所在机构
     *
     */
    public function inOrg($org_id)
    {
        return Auth::user()->org_id == $org_id;
    }

    /**
     * 有管理权
     *
     */
    public function higher($id)
    {
        // 系统管理员
        if($this->root() && !$this->root($id)) return true;
        if($this->admin() && !$this->admin($id)) return true;

        if($this->sameOrg($id)) {
            // 同一单位
            if($this->manager() && !$this->manager($id)) return true;
            if($this->master() && !$this->master($id)) return true;
        } else {
            // 不同单位
            if($this->orgMaster($this->choose($id)->org->id)) return true;
        } 

        return false;
    }


    /**
     * 机构
     * ------------------
     * 
     *
     */
    public function oLocked($org_id)
    {
        return $this->hasAndTrue(Org::find($org_id)->auth, 'locked');
    }

    public function ownOrg($org_id)
    {
        return Auth::user()->org_id == $org_id;
    }

    public function staffOrg($org_id)
    {
        return Org::findOrFail($org_id)->typeConf->key == 'staff';
    }

    public function angentOrg($org_id)
    {
        return Org::findOrFail($org_id)->typeConf->key == 'angent';
    }

    public function customerOrg($org_id)
    {
        return Org::findOrFail($org_id)->typeConf->key == 'customer';
    }

    // END
}
















