<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ExportCompleted;
use App\Mail\ImportCompleted;
use App\Mail\SpecimenGroupCreated;
use App\Mail\SpecimenReviewed;
use App\User;
use Session;

class NotificationsController extends Controller
{
    public function index(User $user)
    {
        $this->logInfo(__METHOD__, "Start ".$user->id. ":".$user->name);

        foreach($user->notifications as $notification) {
            $notification->type = substr(strrchr($notification->type, "\\"), 1);
        }
        $this->viewData['heading'] = trans('labels.notifications');
        $this->viewData['notifications'] = $user->notifications;
        $this->viewData['user'] = $user;

        return view ('notifications.index', $this->viewData);
    }

    public function show(User $user, $id)
    {
        $this->logInfo(__METHOD__, "Start");

        // Retrieve the notification
        $notification = $user->notifications->where('id', $id)->first();

        // If this is the first time the user is viewing the notification, mark it as read
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $this->viewData['notification'] = $notification;
        $this->viewData['user'] = $user;

        //TODO: Check for Reviewed and update
        if($notification->type == 'App\Notifications\ExportCompleted') {
            return (new ExportCompleted($user->id, $notification))->render();
        } else if($notification->type == 'App\Notifications\ImportCompleted') {
            return (new ImportCompleted($user->id, $notification))->render();
        } else if($notification->type == 'App\Notifications\SpecimenReviewed') {
            return (new SpecimenReviewed($user->id, $notification))->render();
        } else if($notification->type == 'App\Notifications\SpecimenGroupCreated') {
            return (new SpecimenGroupCreated($user->id, $notification))->render();
        } else {
            $this->viewData['notifications'] = $user->notifications;
            Session::flash('flash_message', trans('messages.no_notification_information'));
            return view ('notifications.index', $this->viewData);
        }
    }

    public function markAsRead(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, "Start");
        $notificationId = $request['notificationId'];

        // mark the notification as read
        $user->unreadNotifications->where('id', $notificationId)->markAsRead();

        $unreadNotificationsCount = $user->getUnreadNotificationCount();
        $unreadNotifications = $user->getUnreadNotifications();

        return response(array('success' => true, 'unreadNotificationsCount' => $unreadNotificationsCount, 'unreadNotifications' => $unreadNotifications));
    }

    public function markAllRead(User $user)
    {
        $this->logInfo(__METHOD__, "Start ".$user->id.":".$user->name);

        // mark all notifications as read
        $user->unreadNotifications->markAsRead();

        $unreadNotificationsCount = $user->getUnreadNotificationCount();
        $unreadNotifications = $user->getUnreadNotifications();

        return response(array('success' => true, 'unreadNotificationsCount' => $unreadNotificationsCount, 'unreadNotifications' => $unreadNotifications));
    }
}