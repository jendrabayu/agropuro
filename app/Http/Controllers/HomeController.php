<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.home', [
            'categories' => Category::all(),
            'latestProduct' => get_product_with_sales()->latest()->take(9)->get(),
            'featuredProduct' =>  Product::inRandomOrder()->take(8)->get(),
            'salesProduct' =>  get_product_with_sales()->orderBy('sales', 'desc')->take(9)->get()
        ]);
    }
}
