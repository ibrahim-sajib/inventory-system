<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Contract\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;

class IndexProductController extends Controller
{

    public function __invoke(Request $request,
    
    ProductRepositoryInterface $productRepository)
    {
        $products = $productRepository->all();
        return inertia('Admin/Product/Index', [
            'products' => $products,
        ]);
    }
}