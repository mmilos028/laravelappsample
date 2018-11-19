<?php

namespace App\Http\Controllers\Authenticated;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
//use Illuminate\Config;
//use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class MessagesController extends Controller
{
    public function __construct()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            $this->layout = View::make('layouts.mobile_layout');
        }
        if ($agent->isTablet()) {
            $this->layout = View::make('layouts.desktop_layout');
        } else {
            $this->layout = View::make('layouts.desktop_layout');
        }
    }

    public function index(Request $request){
        return view(
            '/authenticated/messages/index'
        );
    }
}
