<?php

namespace App\Http\Controllers;

use App\Entities\Record;
use Illuminate\Http\Request;
use Auth;

class RecordController extends Controller {

    public function index() {
        if(Auth::user()->type!='admin'){
            return redirect()->back();
        }

        $records = Record::all()->sortByDesc('petitionFirst'); # ordenar por mais recente

        return view('admin.record')->with(['records' => $records]);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
