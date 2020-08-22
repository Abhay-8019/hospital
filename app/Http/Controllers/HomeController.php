<?php

namespace App\Http\Controllers;

use App\OPDMaster;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t = \Input::get('t', 1);
        $pendingVisits = $completedVisits = [];
        if (isDoctor())
        {
            $pendingVisits = (new OPDMaster)->getOPDVisits(['pending' => 1, 'doctor_id' => authUser()->doctor_id]);
            $completedVisits = (new OPDMaster)->getOPDVisits(['completed' => 1, 'doctor_id' => authUser()->doctor_id, 'visit_date' => currentDate()]);
        }

        //dd(authUser()->doctor_id . "->". count($completedVisits));


        return view('home', compact('pendingVisits', 'completedVisits', 't'));
    }
}
