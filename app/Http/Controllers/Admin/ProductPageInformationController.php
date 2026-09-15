<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductPageInformationRequest;
use App\Models\ProductPageInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductPageInformationController extends Controller
{
    public function edit(): View
    {
        return view('admin.product-page-information.edit', [
            'information' => ProductPageInformation::query()->firstOrFail(),
        ]);
    }

    public function update(ProductPageInformationRequest $request): RedirectResponse
    {
        ProductPageInformation::query()->firstOrFail()->update($request->validated());

        return to_route('admin.products.information.edit')->with('success', 'Общие условия для карточек товаров сохранены.');
    }
}
