<?php

namespace App\Http\Controllers;

use App\Entities\Record;
// use Illuminate\Http\Request;
use App\User;
use Auth;

class RecordController extends Controller {

    public function index() {
        if(Auth::user()->type!='admin'){
            return redirect()->back();
        }

        $users = User::with(['human' ,'records'])->where('type', 'student')->get();

        return view('admin.record')->with(['users' => $users]);
    }

    public function show($id) {
        $user = User::with(['human' ,'records'])->where('id', $id)->get()->first();
        
        return view('admin.record_show')->with(['user' => $user]);
    }
}
