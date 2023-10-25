<?php

namespace Modules\Payment\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maviance\S3PApiClient\Model\CollectionRequest;
use Maviance\S3PApiClient\ObjectSerializer;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Notification\Services\FCMService;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Http\Requests\InitPaymentRequest;
use Modules\Payment\Payment\MaviancePayment;
use Modules\Product\Entities\UserProduct;
use Modules\Subscription\Entities\UserAbonnement;
use Modules\Subscription\Transformers\SubscriptionResource;
use Modules\User\Entities\User;

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
//        dd($data);
//        if($data->getCode() == 400) {
//            switch (json_decode($data->responseBody)->respCode) {
//                case 40302: return $this->errorResponse("Numero incorrecte");
//                    break;
//                default: return $this->errorResponse("Veuillez reessayer plutard");
//            }
//        }
        Payment::create([
            'transactionID' => $body->getTrid(),
            'transactionType' => "CASHOUT",
            'phoneNumber' => $body->getServiceNumber(),
            'montant' => $request->amount,
            'service_sigle' => $data->getPayItemId(),
            'user_id' => $request->user()->id,
            'createdAt' => now(),
            'status' => 2,
        ]);
        return $this->successResponse("Data", [
            "res" => $data->container
        ]);
    }

    public function getMethods(Request $request){
        $maviance = new MaviancePayment();
        $data = ObjectSerializer::serializeCollection($maviance->getCashout($request->service),'multi');
        $string = str_replace('"""', '', $data);
        $string = str_replace("\n", '', $string);
        $res = json_decode("[$string]");
        foreach ( $res as $method) {
            switch ($method->merchant) {
                case "CMMTNMOMOCC":
                    {
                        $method->displayName = "MTN";
                        $method->regex = "^(237)?(?!650110360|650073267|650064175)((650|651|652|653|654|680|681|682|683|684|685|686|687|688|689)[0-9]{6}$|(67[0-9]{7})$)";
                    };
                    break;
                case "EUCASHOUT": $method->regex = "^\\+?[1-9]\\d{1,14}$";
                    break;
                case "CMORANGEOMCC":
                    {
                        $method->displayName = "ORANGE";
                        $method->regex = "^(237)?((655|656|657|658|659)[0-9]{6}$|(69[0-9]{7})$)";
                    };
                    break;
                case "CMYOOMEEMONEY": $method->regex = "^(237)?(24)[0-9]{7}$";
                    break;
            }
        }
        return $this->successResponse("Payment methods", [
            "res" => $res
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


    public function callBack(Request $request){
        switch ($request->status) {
            case "SUCCESS": {
                $payment = Payment::where('transactionID', $request->trid)->first();
                if ($payment->metadata['type'] == 'SUBSCRIPTION') {
                    $subscription = UserAbonnement::create(
                        array_filter([
                            'user_id' => $payment->metadata['user_id'],
                            'domain_id' => $payment->metadata['domain_id'],
                            'abonnementType_id' => $payment->metadata['abonnementType_id'],
                            'transactionID' => $payment->metadata['transactionID'],
                            'buyerPhoneNumber' => $payment->metadata['buyerPhoneNumber'],
                            'level_id' => $payment->metadata['level_id'],
                            'speciality_id' => $payment->metadata['speciality_id'],
                            'createdAt' => $payment->metadata['createdAt'],
                            'expireAt' => $payment->metadata['expireAt'],
                        ])
                    );
                }
                if ($payment->metadata['type'] == 'PRODUCT') {
                    $subscription = UserProduct::create(
                        array_filter([
                            'user_id' => $payment->metadata['user_id'],
                            'product_id' => $payment->metadata['product_id'],
                            'contactedPhoneNumber' => $payment->metadata['contactedPhoneNumber'],
                            'createdAt' => $payment->metadata['createdAt'],
                        ])
                    );
                }
                FCMService::send(
                    User::where('id', $payment->metadata['user_id'])->first()->fcm_token,
                    [
                        "type" => "Paiement",
                        "image" => config('app.url')."/img/logo.png",
                        "titre" => 'Paiement Succes',
                        "contenu" => 'Votre transaction a ete effectuée avec succes',
                    ]
                );
            };
            break;
            case "ERROR": {
                $payment = Payment::where('transactionID', $request->trid)->first();
                FCMService::send(
                    User::where('id', $payment->metadata['user_id'])->first()->fcm_token,
                    [
                        "type" => "Paiement",
                        "image" => config('app.url')."/img/logo.png",
                        "title" => 'Paiement Echec',
                        "contenu" => 'Votre transaction a echouée veuillez reessayer',
                    ]
                );
            };
            break;
        }
        return $this->successResponse("Callback", [
            "res" => $payment
        ]);
    }
}
