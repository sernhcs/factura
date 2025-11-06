<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return view('admin.purchase-orders.index');
    }
    public function create()
    {
        return view('admin.purchase-orders.create');
    }
}
