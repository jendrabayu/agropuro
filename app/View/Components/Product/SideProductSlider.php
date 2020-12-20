<?php

namespace App\View\Components\product;

use Illuminate\View\Component;

class SideProductSlider extends Component
{

    public $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function render()
    {
        return view('components.product.side-product-slider');
    }
}
