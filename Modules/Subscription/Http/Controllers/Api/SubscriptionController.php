<?php

namespace Modules\Subscription\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maviance\S3PApiClient\Model\CollectionRequest;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Http\Controllers\Api\PaymentController;
use Modules\Payment\Http\Requests\InitPaymentRequest;
use Modules\Payment\Payment\MaviancePayment;
use Modules\Subscription\Entities\AbonnementType;
use Modules\Subscription\Entities\UserAbonnement;
use Modules\Subscription\Transformers\SubscriptionResource;

class SubscriptionController extends CoreController
{
    public function index(Request $request)
    {
        return $this->successResponse("Got subscriptions", [
            'subscriptions' => SubscriptionResource::collection($request->user()->subscriptions)
        ]);
    }

    public function store(InitPaymentRequest $request)
    {
        $exp = AbonnementType::find($request->type)->duration;

        $payment = (new PaymentController)->index($request)->data;

//        if($payment->getStatusCode() == 404) {
//            return $this->errorResponse($payment->original['message']);
//        }
        $pay = Payment::where('transactionID', json_decode($payment)->data->res->trid)->first();

        $pay->update([
            'metadata' => array_filter([
                'user_id' => $request->user()->id,
                'domain_id' => $request->domain_id,
                'abonnementType_id' => $request->type,
                'transactionID' => json_decode($payment)->data->res->trid,
                'buyerPhoneNumber' => $request->phoneNumber ?? $request->user()->phoneNumber,
                'level_id' => $request->user()->level_id,
                'speciality_id' => $request->user()->speciality_id,
                'createdAt' => now(),
                'expireAt' => now()->addMonths($exp),
                'type' => "SUBSCRIPTION"
            ])
        ]);

        return $this->successResponse("Created subscription successfully", [
            'subscription' => $pay,
            'payment' => json_decode($payment)->data->res
        ]);
    }

    public function show($id)
    {
       return $this->successResponse("Get subscription", [
           'subscription' => new SubscriptionResource(UserAbonnement::find($id))
       ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
