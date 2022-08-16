<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\MailStaf;
use App\Models\Prodi;
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
                return redirect()->route('welcome');
            }else{
                $chkKaprodi = Prodi::where('mngr_id', $chkEmail->nik)->first();
                $chkStaf = KaryawanDosen::where('nik', $chkEmail->nik)->first();

                if($chkKaprodi){
                    $user = User::create([
                        'nik' => $chkStaf->nik,
                        'role' => 'kaprodi',
                    ]);
                    Auth::login($user);
                    return redirect()->route('welcome');
                }else if($chkStaf->fakul_id){
                    $user = User::create([
                        'nik' => $chkStaf->nik,
                        'role' => 'dosen',
                    ]);
                    Auth::login($user);
                    return redirect()->route('welcome');
                }else if($chkStaf->bagian){
                    $chkBagian = Bagian::where('kode', $chkStaf->bagian)->first();
                    $chkDosBag = Prodi::where('id', $chkStaf->bagian)->first();

                    if($chkBagian){
                        if ($chkBagian->nama == 'P3AI') {

                            $user = User::create([
                                'nik' => $chkStaf->nik,
                                'role' => 'bagian',
                            ]);
                            Auth::login($user);
                            return redirect()->route('welcome');
                        }
                    }else if($chkDosBag){
                        $user = User::create([
                            'nik' => $chkStaf->nik,
                            'role' => 'dosenBagian',
                        ]);
                        Auth::login($user);
                        return redirect()->route('welcome');
                    }

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

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        $chkNik = User::where('nik', $request->nik)->first();

        if ($chkNik) {
            if (!$chkNik->password) {
                $update = User::where('nik', $request->nik)->update([
                    'password' => bcrypt('123456'),
                ]);
            }

        }else{
            $chkKaprodi = Prodi::where('mngr_id', $request->nik)->first();
            $chkStaf = KaryawanDosen::where('nik', $request->nik)->first();

            if($chkKaprodi){
                $user = User::create([
                    'nik' => $chkStaf->nik,
                    'role' => 'kaprodi',
                    'password' => bcrypt('123456'),
                ]);
            }else if($chkStaf){
                if($chkStaf->fakul_id){
                    $user = User::create([
                        'nik' => $chkStaf->nik,
                        'role' => 'dosen',
                        'password' => bcrypt('123456'),
                    ]);

                }else if($chkStaf->bagian){
                    $chkBagian = Bagian::where('kode', $chkStaf->bagian)->first();
                    $chkDosBag = Prodi::where('id', $chkStaf->bagian)->first();

                    if($chkBagian){
                        if ($chkBagian->nick == 'P3AI') {

                            $user = User::create([
                                'nik' => $chkStaf->nik,
                                'role' => 'bagian',
                                'password' => bcrypt('123456'),
                            ]);

                        }
                    }else if($chkDosBag){
                        $user = User::create([
                            'nik' => $chkStaf->nik,
                            'role' => 'dosenBagian',
                            'password' => bcrypt('123456'),
                        ]);

                    }

                }
            }

        }

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('welcome'));
        }

        Session::flash('message', 'Maaf, NIK atau PIN salah');
        Session::flash('alert-class', 'alert-danger');
        return back();

    }
}
