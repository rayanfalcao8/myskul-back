<?php

namespace Modules\Payment\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Payment\Payment\MaviancePayment;

class PaymentController extends CoreController
{
    public function index()
    {
        $maviance = new MaviancePayment();

        print_r($maviance->initTransaction());
        return $this->successResponse("Data", [
            "res" => $maviance->initTransaction()
        ]);
    }

    public function completePayment()
    {
        $maviance = new MaviancePayment();

        print_r($maviance->completeTransaction());
        return $this->successResponse("Data", [
            "res" => $maviance->completeTransaction()
        ]);
    }

    public function getMethods(){
        $maviance = new MaviancePayment();

        print_r($maviance->getCashout());
        return $this->successResponse("Payment methods", [
            "res" => json_encode($maviance->getCashout())
        ]);
    }

    public function checkStatus($trid){
        $maviance = new MaviancePayment();
        print_r($maviance->checkStatus($trid));
        return $this->successResponse("Payment methods", [
            "res" => json_encode($maviance->checkStatus($trid))
        ]);
    }
}
