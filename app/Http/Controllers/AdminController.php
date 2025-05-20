<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecon;
use App\Models\Exame;

class AdminController extends Controller
{
    public function leconForm()
    {
        $lecons = Lecon::all();
        return view('admin.lecon', compact('lecons'));
    }

    public function storeLecon(Request $request)
    {
        Lecon::create(['name' => $request->name]);
        return redirect()->back();
    }

    public function deleteLecon($id)
    {
        Lecon::destroy($id);
        return redirect()->back();
    }

    public function exameForm()
    {
        $exames = Exame::all();
        return view('admin.exame', compact('exames'));
    }

    public function storeExame(Request $request)
    {
        Exame::create(['name' => $request->name]);
        return redirect()->back();
    }

    public function deleteExame($id)
    {
        Exame::destroy($id);
        return redirect()->back();
    }


    public function dashboard()
{
    return view('admin.dashboard');
}

public function showAddLeconForm()
{
    return view('admin.add-lecon'); // غادي نخلقو هاد الڤيو من بعد
}

}
