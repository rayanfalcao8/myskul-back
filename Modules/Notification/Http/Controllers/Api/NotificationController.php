<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Notification\Entities\Notification;

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
}
