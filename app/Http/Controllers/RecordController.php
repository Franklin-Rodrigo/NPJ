<?php

namespace App\Http\Controllers;

use App\Entities\Record;
use Illuminate\Http\Request;
use App\User;
use Auth;

class RecordController extends Controller {

    public function index() {
        if(Auth::user()->type!='admin'){
            return redirect()->back();
        }

        $user = User::with(['human' ,'records'])->where('type', 'student')->get();

        return view('admin.record')->with(['records' => $user]);
    }
}
