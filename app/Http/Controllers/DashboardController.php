<?php

namespace App\Http\Controllers;

use App\Models\BestSeller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $getFunction;
    private $bestSeller;

    public function __construct(BestSeller $bestSeller)
    {
        $this->getFunction = new AllFunctionController();
        $this->bestSeller = $bestSeller;
    }

    public function index(Request $request)
    {
        $data['title'] = 'Dash Board';
        $data['titleDetail'] = 'Best Seller';
        if ($request->input('travel_date')) $data['travel_date'] = $request->input('travel_date'); else $data['travel_date'] = date('m/d/Y');

        $data['model'] = $this->bestSeller;
        $data['getFunction'] = $this->getFunction;

        $data['bestSeller'] = $this->bestSeller->orderBy('dep_id', 'asc')->limit(6)->get();

        return view('dashboard.index', $data);
    }
}