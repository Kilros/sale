<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use App\Models\User; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        return view('login.forget');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        if(User::where('email', $request->get('email'))->first()){
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
            Mail::send('email.forgetPassword', [
                'token' => $token
            ], function($message) use($request){
                $message->to($request->email);
                $message->subject('Đặt lại mật khẩu');
            });
            return back()->withSuccess("Vui lòng kiểm tra email");
            // return back()->with('message', 'We have e-mailed your password reset link!');
        }
        else{
            return redirect("forget")->with('error', "Email chưa được đăng ký!");
        }
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token) { 
        $updatePassword = DB::table('password_resets')
                            ->where([
                                'token' => $token
                            ])
                            ->first();
        if(!$updatePassword){
            // return back()->withInput()->with('error', 'Invalid token!');
            return redirect('/login')->with('error', "Token không tồn tại!");
        }
        return view('login.forgetPasswordLink', [
            'token' => $token
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            // 'email' => 'required|email|exists:users',
            'password' => [
                'required',
                'string',
                'min:6',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&.]/', // must contain a special character
            ],
            // 'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where([
                            // 'email' => $request->email, 
                            'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            // return back()->withInput()->with('error', 'Invalid token!');
            return back()->with('error', "token không đúng!");
        }
        $user = User::where('email', $updatePassword->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();

        return redirect('/login')->withSuccess("Đặt lại mật khẩu thành công!");
    }
}
