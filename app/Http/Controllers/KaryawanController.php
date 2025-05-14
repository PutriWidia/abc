<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use App\Models\Catatan;
use App\Models\Pengeluaran;
use App\Models\Laporan;
use App\Models\LaporanKaryawan;

use App\Models\Karyawan;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.karyawan-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('karyawan')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/karyawan-home');
        }

        return back()->withErrors([
            'username' => 'username atau password salah.',
        ]);
    }

    public function index()
    {
        $karyawan = Auth::guard('karyawan')->user();

        $data = Catatan::all();
        
        if (!$karyawan) {
            return redirect()->route('karyawan.login')->with('error', 'Harap login terlebih dahulu.');
        }

        $today = Carbon::today();

        $catatansChecked = Catatan::where('checked', 1)->get();

        $pendapatan = Catatan::where('status', 'Lunas')->where('nama_karyawan', Auth::guard('karyawan')->user()->username)
        ->whereDate('created_at', $today)
        ->sum('harga') ?? 0;
        $checkPendapatan = Catatan::where('status', 'Lunas')->orWhere('status', 'Belum')->count() ?? 0;
        
        $pengeluaran = Pengeluaran::whereDate('created_at', $today)
        ->sum('nominal') ?? 0;

        $cariUser = LaporanKaryawan::whereDate('created_at', Carbon::today())
            ->where('nama_karyawan', $karyawan->username)
            ->first();
        $laporanKaryawan = Laporan::where('nama_karyawan', $karyawan->username)->get() ?? collect();
        $pendapatanKaryawan = Laporan::where('status_pembayaran', 'Lunas')
    ->whereDate('created_at', $today)
    ->sum('harga') ?? 0;

    // LaporanKaryawan::create([
    //             'nama_karyawan' => Auth::guard('karyawan')->user()->username,
    //             'pendapatan' => $pendapatan,
    //             'pengeluaran' => $pengeluaran,
    //             'pendapatan_bersih' => $pendapatan - $pengeluaran,
    //             'waktu' => now(),
    //             'tanggal' => now(),
    //         ]);
        // dd($cariUser);
        if ($cariUser) {
            if ($checkPendapatan == 0) {
               $cariUser->update([
                    'pendapatan' => $pendapatanKaryawan,
                    'pengeluaran' => $pengeluaran,
                    'pendapatan_bersih' => $pendapatanKaryawan - $pengeluaran,
                    'waktu' => now(),
                    'tanggal' => now(),
                ]);
            }else{

                $cariUser->update([
                'pendapatan' => $pendapatan,
                'pengeluaran' => $pengeluaran,
                'pendapatan_bersih' => $pendapatan - $pengeluaran,
                'waktu' => now(),
                'tanggal' => now(),
            ]);
            }
        } else {
            LaporanKaryawan::create([
                'nama_karyawan' => Auth::guard('karyawan')->user()->username,
                'pendapatan' => $pendapatan,
                'pengeluaran' => $pengeluaran,
                'pendapatan_bersih' => $pendapatan - $pengeluaran,
                'waktu' => now(),
                'tanggal' => now(),
            ]);
        }
        // LaporanKaryawan::create([
        //     'nama_karyawan' => Auth::guard('karyawan')->user()->username,
        //     'pendapatan' => $pendapatan,
        //     'pengeluaran' => $pengeluaran,
        //     'pendapatan_bersih' => $pendapatan - $pengeluaran,
        //     'waktu' => now(),
        //     'tanggal' => now(),
        // ]);

        $pendapatanBersih = $pendapatan - $pengeluaran;

        

        return view('karyawan-home', [
            'username' => $karyawan->username,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'pendapatanBersih' => $pendapatanBersih,
        ]);
    }

    public function update(Request $request)
    {
        $karyawan = karyawan::find($request->id);

        if (!$karyawan) {
            return redirect()->route('karyawan.login')->with('error', 'Harap login terlebih dahulu.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'jenis_kelamin' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        // dd($request);
        $karyawan->update([
            'username' => $request->nama,
            // 'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telp,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('success', 'Data karyawan berhasil diperbarui.');
    }
}
