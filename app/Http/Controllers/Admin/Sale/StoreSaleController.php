<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Contract\Repositories\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Contract\Repositories\SaleRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class StoreSaleController extends Controller
{

    public function __invoke(
        StoreSaleRequest $request,
        SaleRepositoryInterface $saleRepository,
        ProductRepositoryInterface $productRepository
    )
    {
        $data = $request->validated();

        $saleData = prepare_sale_calculation($data);

        // dd($saleData);
        $saleData['customer_name'] = $data['customer_name'];

        $sale = $saleRepository->create($saleData);
        $productRepository->updateProductStocks($saleData['products']);
        $sale->products()->attach($saleData['products']);

        return redirect()->back()->with('success', 'Sale created successfully!');
    }
}