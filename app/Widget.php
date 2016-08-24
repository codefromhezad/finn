<?php

namespace App;

use Carbon\Carbon;

class Widget
{   
    static public function situation($user) {
        return view('widgets.situation', ['user' => $user])->render();
    }

    static public function carte($user) {
        return view('widgets.carte', ['user' => $user])->render();
    }
}
