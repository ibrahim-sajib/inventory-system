<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Contract\Repositories\ProductRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class StoreProductController extends Controller
{

    public function __invoke(
        StoreProductRequest $request,
         ProductRepositoryInterface $productRepository
    )
    {
        $payload = $request->validated();
        $productRepository->create($payload);

        return redirect()->back()->with('success', 'Product created successfully!');
    }
}