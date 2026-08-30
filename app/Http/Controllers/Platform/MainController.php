<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Attachments;
use App\Models\Complaint;
use App\Models\Lookups;
use Illuminate\Http\Request; // ✅ استخدم هذا
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function index()
    {
        $data["project_types"] = Lookups::query()->where([
            "master_key" => "project_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        $data["provinces"] = Lookups::query()
            ->where("master_key", "province")
            ->whereNot("parent_id", 0)
            ->where("status", 1)
            ->get();

        return view('site.index', $data);
    }

    public function complaints(Request $request) // ✅ $request هو كائن Request
    {
        $validator = Validator::make($request->all(), [
            'complainant_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'type' => 'required|in:complaint,suggestion,inquiry',
            'details' => 'required|string|max:1000',
        ], [
            'complainant_name.required' => 'الاسم الكامل مطلوب',
            'phone_number.required' => 'رقم الهاتف مطلوب',
            'type.required' => 'نوع الطلب مطلوب',
            'details.required' => 'تفاصيل الرسالة مطلوبة',
            'details.min' => 'يجب أن تكون التفاصيل 10 أحرف على الأقل',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $complaint = Complaint::create([
            'complainant_name' => $request->complainant_name,
            'phone_number' => $request->phone_number,
            'type' => $request->type,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رسالتك بنجاح، سيتواصل معك فريقنا قريباً.',
            'data' => $complaint
        ], 201);
    }

    public function getClassesByAgeGroup(Request $request)
    {
        $ageGroupId = $request->age_group_id;

        $classes = \App\Models\Lookups::where('master_key', 'age_group')
            ->where('parent_id', $ageGroupId)
            ->where('status', 1)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $classes
        ]);
    }

}
