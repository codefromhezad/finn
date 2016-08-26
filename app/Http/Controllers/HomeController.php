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
        $new_entry->checked = $request->input('checked') ? 1 : 0;
        $new_entry->label = $request->input('label');
        $new_entry->amount = $request->input('amount-credit') ? 
                             $request->input('amount-credit') : 
                             - $request->input('amount-debit');
        $new_entry->channel_id = $request->input('channel_id');
        $new_entry->user_id = \Auth::user()->id;
        
        $new_entry->save();

        return redirect()->action('HomeController@dashboard');
    }

    /**
     * Export user's account as CSV.
     *
     * @return \Illuminate\Http\Response
     */
    public function csv_export(Request $request)
    {
        $entries = \App\BudgetEntry::where('user_id', \Auth::user()->id)
                                ->orderBy('date', 'asc')
                                ->get();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['id', 'date', 'checked', 'label', 'amount', 'payment_type']);

        foreach ($entries as $entry) {
            $entry_array = [
                $entry->id,
                $entry->date,
                $entry->checked,
                $entry->label,
                $entry->amount,
                \App\BudgetChannel::find($entry->channel_id)->label
            ];

            $csv->insertOne($entry_array);
        }

        $csv->output('finn-export.csv');
    }


    /**
     * Update an entry "check" from an ajax request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_toggle_check_entry(Request $request)
    {
        $entry_id = $request->input('entry_id');
        $checked_status = $request->input('checked') ? 1 : 0;

        $entry = \App\BudgetEntry::find($entry_id);

        if( $entry->user_id != \Auth::user()->id ) {
            die('Wat ?');
        }

        $entry->checked = $checked_status;
        $entry->save();

        return response()->json([
            'status' => 'ok',
            'widget-situation' => \App\Widget::situation(\Auth::user()),
            'widget-carte' => \App\Widget::carte(\Auth::user())
        ]);
    }


    /**
     * Update an entry from an ajax request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_edit_entry(Request $request)
    {
        $entry_id = $request->input('entry_id');

        $entry = \App\BudgetEntry::find($entry_id);

        if( $entry->user_id != \Auth::user()->id ) {
            die('Wat ?');
        }

        $entry->date = Carbon::createFromFormat('d/m/Y', $request->input('date'));
        $entry->label = $request->input('label');
        $entry->amount = $request->input('amount-credit') ? 
                             $request->input('amount-credit') : 
                             - $request->input('amount-debit');
        $entry->channel_id = $request->input('channel_id');

        $entry->save();

        $entry = \App\BudgetEntry::find($entry_id);

        return response()->json([
            'status' => 'ok',
            'widget-situation' => \App\Widget::situation(\Auth::user()),
            'widget-carte' => \App\Widget::carte(\Auth::user()),
            'line-entry' => view('partials._entries_table_line', ['entry' => $entry])->render()
        ]);
    }


    /**
     * Delete an entry from an ajax request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_delete_entry(Request $request)
    {
        $entry_id = $request->input('entry_id');

        $entry = \App\BudgetEntry::find($entry_id);

        if( $entry->user_id != \Auth::user()->id ) {
            die('Wat ?');
        }

        $entry->delete();

        return response()->json([
            'status' => 'ok',
            'widget-situation' => \App\Widget::situation(\Auth::user()),
            'widget-carte' => \App\Widget::carte(\Auth::user())
        ]);
    }
}
