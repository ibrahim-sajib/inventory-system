<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Contract\Repositories\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Contract\Repositories\SaleRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use App\Events\SaleCreated;

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

        $saleData['customer_name'] = $data['customer_name'];

        $sale = $saleRepository->create($saleData);
        $productRepository->updateProductStocks($saleData['products']);
        $sale->products()->attach($saleData['products']);

        event(new SaleCreated($sale, $saleData));

        return redirect()->back()->with('success', 'Sale created successfully!');
    }
}