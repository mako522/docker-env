<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateData;
use Illuminate\Support\Facades\Auth;
use App\Time;

class UpdateController extends Controller
{
    public function editTimeForm(int $id){
        $times = new Time;
        $params = Time::where('time_name')->get();
        $result = $times->find($id);

        return view('edit_time',[
           'times'=>$times,
           'result'=>$result,
        ]);
    }
    public function editTime(Request $request,$id){

        $instance = new Time;
        $record = $instance->find($id);
        $times = Time::find($id);

        $columns = ['time_name'];

        foreach($columns as $column){
            $record->$column=$request->$column;
        }

        $times->save();

        return redirect('/');
    }
}
