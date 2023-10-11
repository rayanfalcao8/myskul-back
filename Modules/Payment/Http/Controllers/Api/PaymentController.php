<?php

namespace Modules\Payment\Http\Controllers\Api;

use Illuminate\Http\Request;
use Maviance\S3PApiClient\Model\CollectionRequest;
use Maviance\S3PApiClient\ObjectSerializer;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Payment\Http\Requests\InitPaymentRequest;
use Modules\Payment\Payment\MaviancePayment;

class PaymentController extends CoreController
{
    public function index(InitPaymentRequest $request)
    {
        $maviance = new MaviancePayment();
        $data = $maviance->initTransaction($request);
        $body = new CollectionRequest([
            'quoteId' => $data->getQuoteId(),
            'customerPhonenumber' => $request->phoneNumber,
            'customerEmailaddress' => $request->user()->email,
            'customerName' => $request->user()->name,
            'customerAddress' => $request->user()->town,
            'serviceNumber' => $request->phoneNumber,
            'trid' => rand(00000000, 99999999)
        ]);
        $data = $maviance->completeTransaction($body);

        return $this->successResponse("Data", [
            "res" => $data->container
        ]);
    }

    public function getMethods(Request $request){
        $maviance = new MaviancePayment();
        $data = ObjectSerializer::serializeCollection($maviance->getCashout($request->service),'multi');
        $string = str_replace('"""', '', $data);
        $string = str_replace("\n", '', $string);

        return $this->successResponse("Payment methods", [
            "res" => json_decode("[$string]")
        ]);
    }

    public function checkStatus($trid){
        $maviance = new MaviancePayment();
        $data = ObjectSerializer::serializeCollection($maviance->checkStatus($trid),'multi');
        $string = str_replace('"""', '', $data);
        $string = str_replace("\n", '', $string);
        return $this->successResponse("Payment methods", [
            "res" => json_decode("[$string]")
        ]);
    }


    public function callBack($trid){
        $maviance = new MaviancePayment();
        $data = ObjectSerializer::serializeCollection($maviance->checkStatus($trid),'multi');
        $string = str_replace('"""', '', $data);
        $string = str_replace("\n", '', $string);
        return $this->successResponse("Payment methods", [
            "res" => json_decode("[$string]")
        ]);
    }
}
