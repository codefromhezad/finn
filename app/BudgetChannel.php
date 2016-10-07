<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetChannel extends Model
{   
    protected $table = "budget_channels";
    protected $default_slug_to_select = "carte-credit";

    public function html_select_id($id_to_select) {
    	if( isset($id_to_select) ) {
    		if( $id_to_select == $this->id ) {
    			return " selected ";
    		}
    	} else {
    		if( $this->slug == $this->default_slug_to_select ) {
    			return " selected ";
    		}
    	}
    	return "";
    }
}
