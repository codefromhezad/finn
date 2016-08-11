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
        return BudgetEntry::where('user_id', \Auth::user()->id)
                        ->where('checked', 1)
                        ->sum('amount');
    }

    public static function realAccount() {
        return BudgetEntry::where('user_id', \Auth::user()->id)
                        ->sum('amount');
    }

    public function debitAmount() {
        if($this->amount < 0) {
            return abs($this->amount) . " " . BudgetEntry::CURRENCY;
        }
        return "";
    }

    public function creditAmount() {
        if($this->amount > 0) {
            return abs($this->amount) . " " . BudgetEntry::CURRENCY;
        }
        return "";
    }
}
