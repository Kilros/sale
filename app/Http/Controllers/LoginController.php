<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect('admin');
        }
        $remember = json_decode(request()->cookie('info'), True);
        return view("login.index",[
            'Remember' => $remember,
        ]);
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
        $remember = $request->get('remember');
        $credentials = $request->only('email', 'password'); 
        if (Auth::attempt($credentials, $remember)) {
            if($remember){
                $minutes = 30*24*60;
                $data = [
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                ];
                Cookie::queue('info', json_encode($data), $minutes);
            }
            else{
                Cookie::queue(Cookie::forget('info'));
            }
            return redirect()->intended('admin')
                        ->withSuccess('Đăng nhập thành công');
        }
  
        return redirect("login")->with('error', 'Tài khoản không chính xác!');
    }

    public function registration()
    {
        return view('register.index');
    }
      
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:6',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&.]/', // must contain a special character
            ],
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }
//------THÊM VÀO DATABASE
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'level' => 1,
      ]);
    }    
    
    // public function dashboard()
    // {
    //     if(Auth::check()){
    //         return view('admin',[
    //             'user' => Auth::user(),
    //         ]);
    //     }
  
    //     return redirect("login")->withSuccess('You are not allowed to access');
    // }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
