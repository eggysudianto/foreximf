<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use DB;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $member = Member::select(DB::raw("members.id as member_id, members.nama as nama_member, members.parent_id, (select a.nama from members a where a.id = members.parent_id) as nama_parent, members.status"))
        ->whereIn('status', ["aktif","nonaktif"])
        ->orderBy("members.id","asc")
        ->get();

        return view('member', compact('member'));
    }


     public function treeView(){     
        $Members = Member::whereRaw("parent_id = 0 and status='aktif'")->get();
        $tree='';
        foreach ($Members as $member) {
            $tree .='<li class="tree-view closed"<span class="tree-name">'.$member->nama.'</span>';
            if(count($member->childs)) {
                $tree .=$this->childView($member);
            }
        }
        $tree .='';
        return view('treeview',compact('tree'));
    }

    public function childView($member){                 
        $html ='<ul>';
        foreach ($member->childs as $arr) {
            if(count($arr->childs)){
                if($arr->status=="aktif"){
                    $html .='<li class="tree-view closed"><span class="tree-name">'.$arr->nama.'</span>';                  
                    $html.= $this->childView($arr);
                }
            }else{
                if($arr->status=="aktif"){
                    $html .='<li class="tree-view"><span class="tree-name">'.$arr->nama.'</span>';                                 
                    $html .="</li>";
                }
            }
        }
        
        $html .="</ul>";
        return $html;
    }    
}
