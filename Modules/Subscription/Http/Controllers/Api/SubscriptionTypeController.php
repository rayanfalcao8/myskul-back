<?php

namespace Modules\Subscription\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Subscription\Entities\AbonnementType;

class SubscriptionTypeController extends CoreController
{
    public function index(Request $request)
    {
        return $this->successResponse("Got subscriptions", [
            'subscriptions' => AbonnementType::query()->get()
        ]);
    }

    public function store(Request $request)
    {
        $subscription = AbonnementType::create(
            array_filter([
                'category' => $request->category,
                'timeUnit' => $request->timeUnit,
                'duration' => $request->duration,
            ])
        );
        return $this->successResponse("Created subscription type successfully", [
            'subscription_type' => $subscription
        ]);
    }

    public function show($id)
    {
        return $this->successResponse("Get subscription type", [
            'subscription_type' => AbonnementType::find($id)
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
