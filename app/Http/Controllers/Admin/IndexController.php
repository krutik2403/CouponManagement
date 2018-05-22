<?php

namespace App\Http\Controllers\Admin;

use App\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return redirect('admin/coupons');
        //return view('admin.index', ['reports' => new Reports()]);
    }
}
