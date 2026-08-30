<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Google2FA;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacher=Auth::user();
        return view('teacher.dashboard',compact('teacher'));
    }
    public function profile()
    {
        $teacher=Auth::user();
        return view('teacher.profile.index',compact('teacher'));
    }
    public function profileEdit()
    {
        $teacher=Auth::user();
        return view('teacher.profile.edit',compact('teacher'));

    }
    public function profileUpdate(Request $request)
    {
        $teacher = Auth::user();

        // تجهيز البيانات للتحديث
        $data = $request->only([
            'teacher_name',
            'email',
            'phone_number',
            'national_id',
            'birth_date',
            'gender',
            'address',
            'province_id',
            'city_id',
            'district_id',
            'age_group_id',
            'specializations',
            'experience_years',
            'qualifications',
            'certificates',
            'previous_experience',
            'availability',
            'notes'
        ]);

        // معالجة رفع الصورة الشخصية
        if ($request->hasFile('profile_image')) {
            // حذف الصورة القديمة
            if ($teacher->profile_image) {
                Storage::disk('public')->delete($teacher->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('teachers/profile_images', 'public');
        }

        // معالجة رفع السيرة الذاتية
        if ($request->hasFile('cv_file')) {
            if ($teacher->cv_file) {
                Storage::disk('public')->delete($teacher->cv_file);
            }
            $data['cv_file'] = $request->file('cv_file')->store('teachers/cv_files', 'public');
        }

        // معالجة رفع ملف الشهادات
        if ($request->hasFile('certificates_file')) {
            if ($teacher->certificates_file) {
                Storage::disk('public')->delete($teacher->certificates_file);
            }
            $data['certificates_file'] = $request->file('certificates_file')->store('teachers/certificates', 'public');
        }

        // معالجة رفع صورة الهوية
        if ($request->hasFile('id_photo')) {
            if ($teacher->id_photo) {
                Storage::disk('public')->delete($teacher->id_photo);
            }
            $data['id_photo'] = $request->file('id_photo')->store('teachers/id_photos', 'public');
        }

        // تحديث كلمة المرور إذا تم إدخالها
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // تحديث البيانات
        $teacher->update($data);

        return redirect()
            ->route('teachers.profile.edit')
            ->with('success', __('engineering.Profile updated successfully'));
    }


    public function update_password(Request $request)
    {

        $request->validate([
            'currentpassword' => ['required'],
            'newpassword' => ['required', 'string', 'min:8'],
            'confirmpassword' => ['required', 'same:newpassword'],
        ], [
            'currentpassword.required' => __('engineering.current_password_required'),
            'newpassword.required' => __('engineering.new_password_required'),
            'newpassword.min' => __('engineering.password_min_length'),
            'confirmpassword.required' => __('engineering.confirm_password_required'),
            'confirmpassword.same' => __('engineering.passwords_do_not_match'),
        ]);

        $user = Auth::user();

        if (!Hash::check($request->currentpassword, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('engineering.current_password_incorrect'),
            ], 422);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => __('engineering.password_updated_successfully'),
        ]);
    }

    public function enableAuthapp(Request $request)
    {
        try {
            $validated = $request->validate([
                'otp_code' => 'required|string',
            ]);

            $user = Auth::user();
            // Validate the entered code
            if (Google2FA::verifyKey($user->authapp_secret, $request->otp_code)) {
                $user->is_authapp_enabled = 1; // or set to true depending on your implementation
                $user->save();

                return response()->json([
                    'message' => trans("admin.Two-factor authentication enabled successfully"),
                    'user' => $user,
                    'success' => true
                ], 201);
            }else{
                return response()->json([
                    'message' => trans("admin.Invalid code provided"),
                    'user' => $user,
                    'success' => false
                ], 201);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => trans("admin.Validation failed"),
                'errors' => $e->errors()
            ], 422);
        }catch (\Exception $e) {
            // Return general error
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function disableAuthapp()
    {
        $user = Auth::user();
        $user->authapp_secret = null;
        $user->is_authapp_enabled = 0; // or set to false depending on your implementation
        $user->save();

        return redirect()->back()->with('success', trans("admin.Two-factor authentication disabled."));
    }


}
