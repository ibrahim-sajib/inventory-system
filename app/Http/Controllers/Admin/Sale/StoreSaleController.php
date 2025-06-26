<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Contract\Repositories\SaleRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class StoreSaleController extends Controller
{

    public function __invoke(
        StoreSaleRequest $request,
        SaleRepositoryInterface $saleRepository
    )
    {
        // You may need to calculate subtotal, total, due, etc. here
        $data = $request->validated();
        dd($data); // Debugging line, remove in production
        // Example: $this->saleRepository->createWithProducts($data);
        $saleRepository->create($data); // Adjust as per your logic

        return redirect()->back()->with('success', 'Sale created successfully!');
    }
}