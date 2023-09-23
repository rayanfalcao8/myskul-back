<?php

namespace Modules\Payment\Payment;

use Exception;
use GuzzleHttp\Client;
use Maviance\S3PApiClient\ApiClient;
use Maviance\S3PApiClient\Configuration;
use Maviance\S3PApiClient\Model\CollectionRequest;
use Maviance\S3PApiClient\Model\QuoteRequest;
use Maviance\S3PApiClient\Service\AccountApi;
use Maviance\S3PApiClient\Service\ConfirmApi;
use Maviance\S3PApiClient\Service\InitiateApi;
use Maviance\S3PApiClient\Service\MasterdataApi;
use Maviance\S3PApiClient\Service\VerifyApi;

class MaviancePayment
{
    public static $token = "public access key";
    public static $secret = "access secret";
    public static $url = "https://XXXXX";
    public static $xApiVersion = "3.0.0";
    public static $config;
    public static $client;

    function __construct() {
        self::$token = config('app.maviance_token');
        self::$secret = config('app.maviance_secret');
        self::$url = config('app.maviance_url');
        self::$config = new Configuration();
        self::$config->setHost(self::$url);
        self::$client = new ApiClient(self::$token, self::$secret, ['verify' => false]);
    }

    public static function init() {
        $apiInstance = new AccountApi(self::$client, self::$config);
        try {
            $result = $apiInstance->accountGet(self::$xApiVersion);
            print_r($result);
            return "";
        } catch (Exception $e) {
            echo 'Exception when calling AccountApi->accountGet: ', $e->getMessage(), PHP_EOL;
        }
    }

    public static function getCashout() {
        $apiInstance = new MasterdataApi(self::$client, self::$config);
        try {
            return $apiInstance->cashoutGet(self::$xApiVersion);
        } catch (Exception $e) {
            echo 'Exception when calling MasterdataApi->cashoutGet: ', $e->getMessage(), PHP_EOL;
        }
    }

    public static function initTransaction() {
        $apiInstance = new InitiateApi(self::$client, self::$config);
        $body = new QuoteRequest([
            'amount' => 300,
            'payItemId' => "voluptate"
        ]);
        try {
            return $apiInstance->quotestdPost(self::$xApiVersion, $body);
        } catch (Exception $e) {
            echo 'Exception when calling InitiateApi->quotestdPost: ', $e->getMessage(), PHP_EOL;
        }
    }

    public static function checkStatus($trid) {
        $apiInstance = new VerifyApi(self::$client, self::$config);

        $trid = "trid_example"; // string | custom external transaction reference provided during payment collection

        try {
            return $apiInstance->verifytxGet(self::$xApiVersion, null, $trid);
        } catch (Exception $e) {
            echo 'Exception when calling VerifyApi->verifytxGet: ', $e->getMessage(), PHP_EOL;
        }
    }

    public static function completeTransaction() {
        $apiInstance = new ConfirmApi(self::$client, self::$config);
        $body = new CollectionRequest();

        try {
            return $apiInstance->collectstdPost(self::$xApiVersion, $body);
        } catch (Exception $e) {
            echo 'Exception when calling ConfirmApi->collectstdPost: ', $e->getMessage(), PHP_EOL;
        }
    }
}