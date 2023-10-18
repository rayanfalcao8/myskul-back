<?php

namespace Modules\Notification\Http\Controllers\Api;

use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Kutia\Larafirebase\Services\Larafirebase;
use Modules\Notification\Services\FCMService;
use Illuminate\Support\Facades\Notification as N;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Notification\Entities\Notification;
use Modules\User\Entities\User;

class NotificationController extends CoreController
{
    public function index(Request $request)
    {
        return $this->successResponse("User's notifications", [
            'notifications' => Notification::where('user_id', $request->user()->id)->latest()
        ]);
    }

    public function store(Request $request)
    {
        $data = array_filter([
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->get('content'),
            'image' => $request->image,
            'isRead' => $request->isRead,
            'createdAt' => $request->createdAt ?? now(),
            'user_id' => $request->user()->id
        ]);

        $notification = Notification::create($data);

        return $this->successResponse("Notification", [
            'notification' => $notification
        ]);
    }

    public function show($id)
    {
        return $this->successResponse("User's notification", [
            'notification' => Notification::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update(array_filter([
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->get('content'),
            'image' => $request->image,
            'isRead' => $request->isRead,
            'createdAt' => $request->createdAt ?? now(),
            'user_id' => $request->user()->id
        ]));

        return $this->successResponse("User's notification", [
            'notification' => Notification::findOrFail($id)
        ]);
    }

    public function updateAll($id)
    {
        //
    }

    public function send(Request $request)
    {
        try {
            $response = FCMService::send(
                    $request->user()->fcm_token,
                    [
                        'title' => 'your title',
                        'body' => 'your body',
                        'image' => config('app.url')."/img/logo.png"
                    ]
                );
            if ($response->status() == 200) {
                print_r($response->body());
                print_r('Notification sent successfully');
            } else {
                print_r('Failed to send notification: ' . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            print_r('Failed to send notification: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Notification sent']);
    }
}
