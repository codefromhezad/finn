<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BudgetEntry extends Model
{   
    protected $table = "budget_entries";

    const CURRENCY = "€";

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function channel() {
        return $this->belongsTo('App\BudgetChannel');
    }

    public function getDateAttribute($value) {
        return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public static function visibleAccount() {
        return number_format(BudgetEntry::where('user_id', \Auth::user()->id)
                        ->where('checked', 1)
                        ->sum('amount'), 2);
    }

    public static function realAccount() {
        return number_format(BudgetEntry::where('user_id', \Auth::user()->id)
                        ->sum('amount'), 2);
    }

    public static function sumCardInPreviousPeriod($num_days) {
        $channel_id = \App\BudgetChannel::where('slug', 'carte-credit')->first()->id;

        return number_format(abs(BudgetEntry::where('user_id', \Auth::user()->id)
                        ->where('date', '>=', Carbon::now()->subDays($num_days))
                        ->where('channel_id', $channel_id)
                        ->sum('amount')), 2);
    }

    public static function sumWithdrawInPreviousPeriod($num_days) {
        $channel_id = \App\BudgetChannel::where('slug', 'retrait')->first()->id;

        return number_format(abs(BudgetEntry::where('user_id', \Auth::user()->id)
                        ->where('date', '>=', Carbon::now()->subDays($num_days))
                        ->where('channel_id', $channel_id)
                        ->sum('amount')), 2);
    }

    public function debitAmount() {
        if($this->amount < 0) {
            return number_format(abs($this->amount), 2)." ".\App\BudgetEntry::CURRENCY;
        }
        return "";
    }

    public function creditAmount() {
        if($this->amount > 0) {
            return number_format(abs($this->amount), 2)." ".\App\BudgetEntry::CURRENCY;
        }
        return "";
    }
}
