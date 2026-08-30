<?php

namespace App\Http\Controllers\ContractorsPortal;

use App\Http\Controllers\Controller;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Google2FA;

class ContractorsController extends Controller
{
    public function profile()
    {
        $user=Auth::user();

        return view('contractors.profile.index',compact('user'));
    }
    public function profile_settings()
    {
        $user=Auth::user();
        $data['user'] = $user;

        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        
        $is_authapp_enabled = $user->is_authapp_enabled;
        
        $data['mobile_verified_at'] = $user->mobile_verified_at;

        if ($is_authapp_enabled == 0) {
            // Generate a new secret key for 2FA
            $google2fa = Google2FA::generateSecretKey();
            // Save the secret key to the user's record if not already set
            $user->authapp_secret = $google2fa;
            $user->save();

            $QR_Image = Google2FA::getQRCodeInline(
                'One Thousand - Contractors Portal',
                $user->email,
                $user->authapp_secret
            );

            $data['QR_Image'] = $QR_Image;
            $data['authapp_secret'] = $google2fa;
            $data['is_authapp_enabled'] = false;
        }else{
            $data['is_authapp_enabled'] = true;
        }

        return view('contractors.profile.settings',$data);
    }
    public function update_profile_settings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'province_cd' => 'required|integer|exists:lookups,id',
            'city_cd' => 'required|integer|exists:lookups,id',
            'district_cd' => 'required|integer|exists:lookups,id',
            'address' => 'required|string|max:500',
            'experience_years' => 'required|integer|min:0',
            'commercial_registration_number' => 'required|string|max:100',
            'specializations' => 'required|string|max:255',
            'tax_number' => 'required|string|max:100',

            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'commercial_registration' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'liecence' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tax_record' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'previous_projects' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $uploadFields = [
                'logo' => 'logo',
                'company_profile' => 'company',
                'commercial_registration' => 'commercial',
                'liecence' => 'liecence',
                'tax_record' => 'tax',
                'previous_projects' => 'projects',
            ];

            $paths = [];

            foreach ($uploadFields as $field => $prefix) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $prefix . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path("uploads/{$field}"), $fileName);
                    $paths[$field] = "uploads/{$field}/" . $fileName;
                }
            }


            $user->company_name = $validated['company_name'];
            $user->mobile = $validated['mobile'];
            $user->province_cd = $validated['province_cd'];
            $user->city_cd = $validated['city_cd'];
            $user->district_cd = $validated['district_cd'];
            $user->address = $validated['address'];
            $user->experience_years = $validated['experience_years'];
            $user->commercial_registration_number = $validated['commercial_registration_number'];
            $user->specializations = $validated['specializations'];
            $user->tax_number = $validated['tax_number'];

            if (isset($paths['logo'])) {
                $user->logo = $paths['logo'];
            }
            if (isset($paths['company_profile'])) {
                $user->company_profile = $paths['company_profile'];
            }
            if (isset($paths['commercial_registration'])) {
                $user->commercial_registration = $paths['commercial_registration'];
            }
            if (isset($paths['liecence'])) {
                $user->liecence = $paths['liecence'];
            }
            if (isset($paths['tax_record'])) {
                $user->tax_record = $paths['tax_record'];
            }
            if (isset($paths['previous_projects'])) {
                $user->previous_projects = $paths['previous_projects'];
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => __('contractors.profile_updated_successfully')
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('contractors.error_occurred')
            ], 500);
        }
    }


    public function update_password(Request $request)
    {
        $request->validate([
            'currentpassword' => ['required'],
            'newpassword' => ['required', 'string', 'min:8'],
            'confirmpassword' => ['required', 'same:newpassword'],
        ], [
            'currentpassword.required' => __('contractors.current_password_required'),
            'newpassword.required' => __('contractors.new_password_required'),
            'newpassword.min' => __('contractors.password_min_length'),
            'confirmpassword.required' => __('contractors.confirm_password_required'),
            'confirmpassword.same' => __('contractors.passwords_do_not_match'),
        ]);

        $user = Auth::user();

        if (!Hash::check($request->currentpassword, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('contractors.current_password_incorrect'),
            ], 422);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => __('contractors.password_updated_successfully'),
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
        $user->is_authapp_enabled = 0;
        $user->save();

        return redirect()->back()->with('success', trans("admin.Two-factor authentication disabled."));
    }




}
