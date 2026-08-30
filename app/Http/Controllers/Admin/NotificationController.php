<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lands;
use App\Models\Lookups;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    //
    public function list()
    {
        return response()->json([
            'notifications' => auth()->user()
                ->notifications()
                ->latest() // order by created_at descending
                ->take(10) // limit to 10
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'data' => $notification->data,
                        'created_at_human' => $notification->created_at->diffForHumans(),
                        'read_at' => $notification->read_at,
                    ];
                }),
        ]);
    }
    public function engineering_notifications_list()
    {
        return response()->json([
            'notifications' => auth()->user()
                ->notifications()
                ->where('notifiable_type', 'App\Models\EngineeringPartner') // فلترة حسب النوع
                ->latest() // order by created_at descending
                ->take(10) // limit to 10
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'data' => $notification->data,
                        'created_at_human' => $notification->created_at->diffForHumans(),
                        'read_at' => $notification->read_at,
                    ];
                }),
        ]);
    }




    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'all-read']);
    }
    public function markAllEngineeringAsRead()
    {
        Auth::user()->unreadNotifications
            ->where('notifiable_type', 'App\Models\Engineering')
            ->markAsRead();

        return response()->json(['status' => 'all-read']);
    }
    public function markAsRead($id)
    {
        auth()->user()->unreadNotifications()->where('id', $id)->first()?->markAsRead();
        return response()->json(['status' => 'done']);
    }
    public function pageList(){
        return view('admin.SystemSettings.notificationList');
    }
    public function getpageListData(){
        $notification = Notifications::query()->orderBy('id', 'desc');
        return DataTables::of($notification)
            ->addColumn('notifications_message', function ($notification) {
                $data = json_decode($notification->data, true); // تحويل JSON إلى مصفوفة
                $message = $data['message'] ?? '—'; // الحصول على الرسالة أو علامة فارغة
                return '<div class="badge badge-light fw-bold">' . e($message) . '</div>';
            })
            ->addColumn('notifications_created_at', function ($notification) {
                return '<div class="badge badge-light fw-bold">' . $notification->created_at->diffForHumans() . '</div>';
            })
            ->addColumn('notifiable_id', function ($notification) {
                return '<div class="badge badge-light fw-bold">' . $notification->notifiable_id . '</div>';
            })
            ->addColumn('status', function ($notification) {
                $status = $notification->read_at ? trans('admin.readable') : trans('admin.illegible');
                return '<div class="badge badge-light fw-bold">' . $status . '</div>';
            })
            ->addColumn('actions', function ($notification) {
                $actions = '<div class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-info btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';
                if (auth()->user()->can('Land view.blade.php')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/lands/view.blade.php-land/{$notification->id}") . '" class="menu-link px-3">'
                        . trans('admin.View') . '</a>
                             </div>';
                }



                $actions .= '</div></div>';

                return $actions;
            })
            ->rawColumns(['notifications_message','notifications_created_at','notifiable_id','status', 'actions'])
            ->make(true);

    }
}
