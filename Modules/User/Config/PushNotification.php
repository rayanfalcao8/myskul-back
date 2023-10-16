<?php

namespace Modules\User\PushNotifications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Kutia\Larafirebase\Services\Larafirebase;
use Modules\User\Entities\User;

class PushNotification
{
    public function notification(Request $request){
        $request->validate([
            'title'=>'required',
            'message'=>'required'
        ]);

        try{
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));

            /* or */

            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);

            return redirect()->back()->with('success','Notification Sent Successfully!!');

        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error','Something goes wrong while sending notification.');
        }
    }

    private function send($payload): string
    {
        $request = Http::withHeaders($this->headers)->post(env('ONESIGNAL_URL'), $payload);
        return $request->body();
    }


}
