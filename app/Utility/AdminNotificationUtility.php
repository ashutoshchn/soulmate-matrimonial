<?php

namespace App\Utility;

use Carbon\Carbon;
use App\Notifications\DbStoreNotification;
use App\User;
use Auth;
use Notification;


class AdminNotificationUtility
{

    public static function send_for_admin_approval_notification()
    {
        try {
            $notify_type = 'admin_notification_on_member_review'; 
            $id = unique_notify_id();
            $notify_by = Auth::user()->id;
            $info_id = Auth::user()->id;
            $message = Auth::user()->code.' '.Auth::user()->first_name.' '.Auth::user()->last_name.translate(' sent profile for admin review.');
            $route = 'members.show';

            Notification::send(User::where('user_type', 'admin')->first(), new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
            flash(translate('Admin has been notified and will review your account soon.'))->success();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
    public static function send_profileupdate_admin_notification($section)
    {
        if(Auth::user()->approved == 1)
        {

            try {
                $notify_type = 'admin_notification_on_member_review'; 
                $id = unique_notify_id();
                $notify_by = Auth::user()->id;
                $info_id = Auth::user()->id;
                $message = 'Approved member '.Auth::user()->code.' '.Auth::user()->first_name.' '.Auth::user()->last_name.translate(' has updated profile: '.$section.'.');
                $route = 'members.show';

                Notification::send(User::where('user_type', 'admin')->first(), new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
                //flash(translate('Admin has been notified and will review your account soon.'))->success();
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

    }
    

}
