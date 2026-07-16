<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrokerController extends Controller
{
    public function create() : RedirectResponse | View
    {
        return view('admin.brokers.create');
    }
}
