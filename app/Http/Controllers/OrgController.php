<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Org;

class OrgController extends Controller
{
    public function test()
    {
        $all = Org::all();
        // print_r($a);
        foreach ($all as $k) {
            echo($k->id.":");
            foreach ($k->users as $v) {
                echo($v->id);
            }
        }
    }
}
