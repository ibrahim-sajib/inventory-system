<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Contract\Repositories\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\SaleRepositoryInterface;
use Inertia\Inertia;
use Illuminate\Http\Request;

class IndexSaleController extends Controller
{
    public function __invoke(
        Request $request,
        SaleRepositoryInterface $saleRepository,
        ProductRepositoryInterface $productRepository
    )
    {
        $sales = $saleRepository->all();
        return Inertia::render('Admin/Sale/Index', [
            'sales' => $sales,
            'products' => Inertia::lazy(fn () => $productRepository->all())   //should be lazy loaded, also it should be more optimized
        ]);
    }
}