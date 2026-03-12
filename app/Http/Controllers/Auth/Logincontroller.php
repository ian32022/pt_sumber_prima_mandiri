<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN HALAMAN LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $email = $request->email;
        $password = $request->password;


        /*
        |--------------------------------------------------------------------------
        | CEK DOMAIN EMAIL PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        if (!str_contains($email, '@sumberprimamandiri.com')) {
            return back()->with('error','Gunakan email perusahaan');
        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT EMAIL : nama.role@sumberprimamandiri.com
        |--------------------------------------------------------------------------
        */

        $emailParts = explode('@', $email)[0];

        if (!str_contains($emailParts,'.')) {
            return back()->with('error','Format email harus nama.role@sumberprimamandiri.com');
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL NAMA DAN ROLE
        |--------------------------------------------------------------------------
        */

        $parts = explode('.', $emailParts);

        $nama = ucfirst($parts[0]);
        $roleInput = strtolower($parts[1]);


        /*
        |--------------------------------------------------------------------------
        | MAPPING ROLE
        |--------------------------------------------------------------------------
        */

        if ($roleInput == 'admin') {

            $role = 'admin';

        } elseif ($roleInput == 'design') {

            $role = 'engineer';

        } elseif ($roleInput == 'machine') {

            $role = 'operator';

        } else {

            return back()->with('error','Role tidak valid');

        }


        /*
        |--------------------------------------------------------------------------
        | CEK USER DI DATABASE
        |--------------------------------------------------------------------------
        */

        $user = User::where('email',$email)->first();

        if(!$user){

            $user = User::create([
                'nama' => $nama,
                'email' => $email,
                'password_hash' => Hash::make($password),
                'role' => $role
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN USER
        |--------------------------------------------------------------------------
        */

        Auth::login($user);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        if($user->role == 'admin'){
            return redirect('/admin/dashboard');
        }

        if($user->role == 'engineer'){
            return redirect('/design/dashboard');
        }

        if($user->role == 'operator'){
            return redirect('/machining/dashboard');
        }

        return redirect('/login');

    }



    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');

    }

}