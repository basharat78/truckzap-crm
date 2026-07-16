<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BrokerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;





class BrokerController extends Controller
{
    public function index(BrokerDataTable $dataTable) : RedirectResponse | View
    {
        return $dataTable->render('admin.brokers.index');
    }
    public function create() : RedirectResponse | View
    {
        return view('admin.brokers.create');
    }
}
