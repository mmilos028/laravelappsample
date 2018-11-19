<?php

namespace App\Http\Controllers\Authenticated;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
//use Illuminate\Config;
//use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


class MobileMenuController extends Controller
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
            '/authenticated/mobile-menu/index'
        );
    }

    public function administration(){
        return view(
            '/authenticated/mobile-menu/administration'
        );
    }

    public function myAccount()
    {
        return view(
            '/authenticated/mobile-menu/my-account'
        );
    }

    public function language()
    {
        return view(
            '/authenticated/mobile-menu/language'
        );
    }

    public function player()
    {
        return view(
            '/authenticated/mobile-menu/player'
        );
    }

    public function terminal()
    {
        return view(
            '/authenticated/mobile-menu/terminal'
        );
    }

    public function structureEntity()
    {
        return view(
            '/authenticated/mobile-menu/structure-entity'
        );
    }

    public function user()
    {
        return view(
            '/authenticated/mobile-menu/user'
        );
    }

    public function ticket()
    {
        return view(
            '/authenticated/mobile-menu/ticket'
        );
    }
	
	public function report()
    {
        return view(
            '/authenticated/mobile-menu/report'
        );
    }

    public function creditTransfers()
    {
        return view(
            '/authenticated/mobile-menu/credit-transfers'
        );
    }


}
