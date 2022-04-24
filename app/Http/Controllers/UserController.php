<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\KaryawanDosen;
use App\Models\MailStaf;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{

    public function login()
    {
        return view('login.index');
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $callback = Socialite::driver('google')->stateless()->user();

        $data = (object) [
            'name' => $callback->getName(),
            'email' => $callback->getEmail(),
            'avatar' => $callback->getAvatar(),
        ];


        $chkEmail = MailStaf::where('email', $data->email)->first();

        if ($chkEmail) {
            $chkUser = User::where('nik', $chkEmail->nik)->first();
            if($chkUser){
                Auth::login($chkUser);
                return redirect()->route('rps.index');
            }else{
                $chkStaf = KaryawanDosen::where('nik', $chkEmail->nik)->first();

                $chkBagian = Bagian::where('kode', $chkStaf->bagian)->first();
                if($chkStaf->fakul_id || $chkBagian->name == 'P3AI' ){
                    $user = User::create([
                        'nik' => $chkStaf->nik,
                        'role' => $chkStaf->fakul_id ? 'Dosen' : $chkBagian->name,
                    ]);
                    Auth::login($user);
                    return redirect()->route('rps.index');
                }
            }

        }

        Session::flash('message', 'Maaf, Anda tidak memiliki akses ke sistem ini');
        Session::flash('alert-class', 'alert-danger');
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
