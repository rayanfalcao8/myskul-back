<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Product\Entities\Product;
use Modules\Product\Transformers\ProductResource;

class ProductController extends CoreController
{
    public function index()
    {
        return $this->successResponse('Get products', [
            'products' => ProductResource::collection(Product::all())
        ]);
    }

    public function store(Request $request)
    {
        return $this->successResponse('Purchase product', [
            'products' => ProductResource::collection(Product::all())
        ]);
    }

    public function show($id)
    {
        return $this->successResponse('Get product', [
            'product' => new ProductResource(Product::find($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
