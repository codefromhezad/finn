<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    public function dashboard()
    {
        $entries = \App\BudgetEntry::where('user_id', \Auth::user()->id)
                                ->orderBy('date', 'asc')
                                ->take(30)
                                ->get();

        return view('dashboard', ['entries' => $entries]);
    }


    /**
     * Saves a new budget entry and redirects to dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_entry(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date_format:d/m/Y',
            'label' => 'required',
            'amount-credit' => 'required_without:amount-debit|numeric',
            'amount-debit' => 'required_without:amount-credit|numeric',
            'channel_id' => 'required'
        ]);

        $new_entry = new \App\BudgetEntry();

        $new_entry->date = Carbon::createFromFormat('d/m/Y', $request->input('date'));
        $new_entry->label = $request->input('label');
        $new_entry->amount = $request->input('amount-credit') ? 
                             $request->input('amount-credit') : 
                             - $request->input('amount-debit');
        $new_entry->channel_id = $request->input('channel_id');
        $new_entry->user_id = \Auth::user()->id;
        
        $new_entry->save();

        return redirect()->action('HomeController@dashboard');
    }
}
