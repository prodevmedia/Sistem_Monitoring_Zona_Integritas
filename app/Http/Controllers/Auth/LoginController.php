<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UnitKerja;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){        
        $request->validate([
            "email" => 'required|string',
            'password' => 'required|string',
        ]);
        
        $cekUser = User::where('email',$request->only('email'))->first();
        if ($cekUser) {
            if (Auth::attempt($request->only('password','email'))) {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }
    
                return $request->wantsJson()
                    ? new JsonResponse([], 204) : redirect()->intended('/');
            }
        }
        $cekUnitkerja = UnitKerja::where('email',$request->only('email'))->first();
        if ($cekUnitkerja) {                        
            if (Auth::guard('unitkerja')->attempt(['email' => $request->email, 'password' => $request->password])) {                
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }
    
                return redirect()->intended('/');
            }
        }
        throw ValidationException::withMessages([
            "email" => [trans('auth.failed')],
        ]);
    }
    public function logout(Request $request){
        if (Auth::guard('unitkerja')->check()) {
            Auth::guard('unitkerja')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route("login"));
        }
        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route("login"));
    }
}
