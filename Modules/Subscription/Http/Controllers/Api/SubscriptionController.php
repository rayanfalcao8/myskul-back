<?php

namespace Modules\Subscription\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
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

    public function store(Request $request)
    {
        $exp = AbonnementType::find($request->type)->duration;

        $subscription = UserAbonnement::create(
            array_filter([
                'user_id' => $request->user()->id,
                'domain' => $request->domain_id,
                'abonnementType_id' => $request->type,
                //TODO: Manage payment and transaction process
                'transactionID' => 'default',
                'buyerPhoneNumber' => 'none',
                'level_id' => $request->user()->level_id,
                'speciality_id' => $request->user()->speciality_id,
                'createdAt' => now(),
                'expireAt' => now()->addMonths($exp),
            ])
        );
        return $this->successResponse("Created subscription successfully", [
            'subscription' => new SubscriptionResource($subscription)
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
