<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function themedelete(Request $request){
        return redirect()->route("indexroute",["change"=>"delete"]);
    }

    public function delete_conscious(){
        return redirect(route("indexroute"));
    }
}
