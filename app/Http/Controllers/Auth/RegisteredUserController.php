<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_code' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
            'gender' => ['required', 'in:male,female'],
            'birth_day' => ['required', 'integer', 'min:1', 'max:31'],
            'birth_month' => ['required', 'integer', 'min:1', 'max:12'],
            'birth_year' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'nationality' => ['required', 'string'],
            'residence_country' => ['required', 'string'],
            'domain' => ['required', 'in:ta3lim_quran,dorous_diniya,ta3lim_lugha'],
            'fi2a' => ['required', 'in:sighar,kibar'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_day' => $request->birth_day,
            'birth_month' => $request->birth_month,
            'birth_year' => $request->birth_year,
            'nationality' => $request->nationality,
            'residence_country' => $request->residence_country,
            'user_type' => 'talib',
            'domain' => $request->domain,
            'fi2a' => $request->fi2a,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('student.dashboard')->with('success', 'تم تسجيل الطالب بنجاح!');
    }
}
