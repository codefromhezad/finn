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
