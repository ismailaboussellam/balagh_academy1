<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * عرض صفحة الملف الشخصي للمدير
     */
    public function index()
    {
        $user = Auth::user();
        $admin = $user->admin;
        
        return view('admin.profile', compact('user', 'admin'));
    }

    /**
     * تحديث معلومات الملف الشخصي للمدير
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $admin = $user->admin;

        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // تحديث بيانات المستخدم
        $user->email = $request->email;
        
        // تحديث كلمة المرور إذا تم تقديمها
        if ($request->filled('password')) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        // تحديث بيانات المدير
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->phone = $request->phone;
        $admin->position = $request->position;
        $admin->save();

        return redirect()->route('admin.profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * تحديث صورة الملف الشخصي
     */
    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => ['required', 'image', 'max:2048'], // الحد الأقصى 2 ميجابايت
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        // حذف الصورة القديمة إذا كانت موجودة
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // تخزين الصورة الجديدة
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $path;
        $user->save();

        return redirect()->route('admin.profile')
            ->with('success', 'تم تحديث صورة الملف الشخصي بنجاح');
    }
}