<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;

class LeadsController extends Controller
{
    public function index()
    {
        $leads = Lead::latest('sent_at')->paginate(20);

        return view('admin.leads.index', compact('leads'));
    }
}
