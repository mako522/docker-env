<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateData;
use Illuminate\Support\Facades\Auth;
use App\Time;

class DeleteController extends Controller
{
    
    public function destroy($id)
    {
        $time = Time::find($id);
        $time->delete();
        return redirect()->route('select.time');

    }
}
