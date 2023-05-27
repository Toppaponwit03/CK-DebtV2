<?php

namespace App\Http\Controllers;
use App\Models\tbl_traceEmployee;
use Illuminate\Http\Request;

class ComController extends Controller
{

    public function index(Request $request)
    {
        if($request->type == 1){
            $dataBranch = tbl_traceEmployee::getBranch();
            return view('data_Commission.section-view.view',compact('dataBranch'));
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


}
