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
                return redirect()->route('beranda.index');
            }else{
                $chkKaprodi = Prodi::where('mngr_id', $chkEmail->nik)->first();
                $chkStaf = KaryawanDosen::where('nik', $chkEmail->nik)->first();

                if($chkKaprodi){
                    $user = User::create([
                        'nik' => $chkStaf->nik,
                        'role' => 'kaprodi',
                    ]);
                    Auth::login($user);
                    return redirect()->route('beranda.index');
                }else if($chkStaf->fakul_id){
                    $user = User::create([
                        'nik' => $chkStaf->nik,
                        'role' => 'dosen',
                    ]);
                    Auth::login($user);
                    return redirect()->route('beranda.index');
                }else if($chkStaf->bagian){
                    $chkBagian = Bagian::where('kode', $chkStaf->bagian)->first();

                    if($chkBagian){
                        if ($chkBagian->nama == 'P3AI') {

                            $user = User::create([
                                'nik' => $chkStaf->nik,
                                'role' => 'p3ai',
                            ]);
                            Auth::login($user);
                            return redirect()->route('beranda.index');
                        }else if($chkBagian->nama == 'PIMPINAN'){

                            $user = User::create([
                                'nik' => $chkStaf->nik,
                                'role' => 'pimpinan',
                            ]);
                        }
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
            $chkKaprodi = Prodi::where('mngr_id', $request->nik)->where('sts_aktif', 'Y')->first();
            $chkDekan = Fakultas::where('mngr_id', $request->nik)->where('sts_aktif', 'Y')->first();
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

                    if($chkBagian){
                        if ($chkBagian->nama == 'PUSAT PENGEMB. PEND & AKTIV.INSTR') {

                            $user = User::create([
                                'nik' => $chkStaf->nik,
                                'role' => 'p3ai',
                                'password' => bcrypt('123456'),
                            ]);

                        }else if($chkBagian->nama == 'PIMPINAN'){

                            $user = User::create([
                                'nik' => $chkStaf->nik,
                                'role' => 'pimpinan',
                                'password' => bcrypt('123456'),
                            ]);
                        }
                    }

                }
            }else if($chkDekan){
                $user = User::create([
                    'nik' => $request->nik,
                    'role' => 'dekan',
                    'password' => bcrypt('123456'),
                ]);
            }

        }

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('beranda.index'));
        }

        Session::flash('message', 'Maaf, NIK atau PIN salah');
        Session::flash('alert-class', 'alert-danger');
        return back();

    }

    public function updateRole()
    {
        $chkNik = User::where('nik', Auth::user()->nik)->first();
        if($chkNik){
            $update = User::where('nik', Auth::user()->nik)->update([
                'role' => request('role'),
            ]);
        }
        return redirect()->route('beranda.index');
    }
}
