<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LeadDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class LeadsController extends Controller
{
    public function index(LeadDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render('admin.leads.index');
    }
}
