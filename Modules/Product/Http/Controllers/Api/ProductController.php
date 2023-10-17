<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Http\Controllers\Api\PaymentController;
use Modules\Payment\Http\Requests\InitPaymentRequest;
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

    public function userProducts(Request $request)
    {
        return $this->successResponse('Get user products', [
            'products' => ProductResource::collection($request->user()->products)
        ]);
    }


    public function store(InitPaymentRequest $request)
    {
        $payment = (new PaymentController)->index($request);
//        if($payment->getStatusCode() == 404) {
//            return $this->errorResponse($payment->original['message']);
//        }
        $pay = Payment::where('transactionID', json_decode($payment->data)->data->res->trid)->first();

        $pay->update([
            'metadata' => array_filter([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'transactionID' => json_decode($payment->data)->data->res->trid,
                'contactedPhoneNumber' => $request->phoneNumber ?? $request->user()->phoneNumber,
                'createdAt' => now(),
                'type' => 'PRODUCT'
            ])
        ]);

        return $this->successResponse("Created subscription successfully", [
            'product' => $pay,
            'payment' => json_decode($payment->data)->data->res
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
