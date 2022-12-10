<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use DB;

class PanelController extends Controller
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
        $member = Member::select(DB::raw("members.id as member_id, members.nama as nama_member, members.parent_id, (select a.nama from members a where a.id = members.parent_id) as nama_parent"))
        ->whereIn('status', ["aktif","nonaktif"])
        ->orderBy("members.id","asc")
        ->get();

        return view('panel', compact('member'));
    }

    public function get_parent()
    {
        $id_member= request('id_member');

        $member = Member::where('status', "aktif")
        ->where("id","<>",$id_member)
        ->orderBy("members.id","asc")
        ->get();

        if (count($member) > 0) {
            echo json_encode(array('code' => 1, 'data' => $member));
        } else {
            echo json_encode(array('code' => 0));
        }
    }

    public function get_recursive_child(Request $request)
    {
        $id_member= request('id_member');
        $level= request('level') ?: "1";
        $status= request('status');

        $member = DB::select("call sp_get_recursive_member ($id_member, '$status', null)");

        if($status=="calculate"){
            $member = DB::select("call sp_get_recursive_member ($id_member, '$status', $level)");
        }

        if (count($member) > 0) {
            echo json_encode(array('code' => 1, 'data' => $member));
        } else {
            echo json_encode(array('code' => 0));
        }
    }

    public function register_member_baru(Request $request)
    {
        $inisial_member_baru= request('inisial_member_baru');
        $parent= request('parent')=="tanpaparent" ? 0 : request('parent');

        $register = Member::create([
            "nama" => $inisial_member_baru,
            "parent_id" => $parent,
            "status" => "aktif"
        ]);

        echo json_encode($register->id);
    }

    public function migrasi(Request $request)
    {
        $select_member_migrasi= request('select_member_migrasi');
        $select_parent_migrasi= request('select_parent_migrasi')=="tanpaparent" ? 0 : request('select_parent_migrasi');

        $members = Member::where("id",$select_member_migrasi)->first();

        Member::where('id', $select_member_migrasi)
               ->update([
                   'status' => 'migrasi'
                ]);

        $register = Member::create([
            "nama" => $members->nama,
            "parent_id" => $select_parent_migrasi,
            "status" => "aktif"
        ]);

        Member::where('parent_id', $select_member_migrasi)
               ->update([
                   'parent_id' => $register->id
                ]);

        echo json_encode($register->id);
    }
}
