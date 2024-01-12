<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use DB;
use Auth;

use App\User;
use App\Branch;
use App\BranchSetting;

use App\Http\Requests\StoreBranchSettingEditFormRequest;

class BranchSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	//Branch Setting list
    public function index()
	{	
		if (isAdmin(Auth::User()->role_id)) 
		{
			$branchDatas = Branch::get();
			$branchSettingData = BranchSetting::where('id','=',1)->first();
		}
		else{
			$branchDatas = "";
			$branchSettingData = "";
		}		

		return view('branch_setting.list',compact('branchDatas','branchSettingData')); 
	}


	//Select Branch Data store
	public function store(Request $request)
	{
		$branchId = $request->select_branch;

		if ($branchId != null || $branchId != "") {

			$branchData = Branch::where('id','=', $branchId)->first();

			$branch = BranchSetting::find(1);
			$branch->branch_id = $branchId;
			$branch->branch_name = $branchData->branch_name;
			$branch->save();

			return redirect('/branch_setting/list')->with('message','Successfully Updated');
		}
		else {
			return redirect('/branch_setting/list')->with('message','Data not available');			
		}

				

		//return response()->json($request->all());
	}
}
