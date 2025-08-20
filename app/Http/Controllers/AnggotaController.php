<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Datadiri;
use App\Models\PelunasanPinjaman;
use App\Models\PengajuanPinjaman;
use App\Models\TabManasuka;
use App\Models\TabWajib;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'anggota');

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $anggota = $query->latest()->paginate(10);

        return view('admin.kelola_anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.kelola_anggota.create');
    }

    // Simpan data anggota baru
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
        ]);

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password' => Hash::make('password123'), // Default password
            'role' => 'anggota',
        ]);

        return redirect()->route('kelola_anggota.kelola_anggota')
            ->with('pesan', 'Anggota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('admin.kelola_anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $anggota->id,
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $anggota->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $anggota->update([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        return redirect()->route('kelola_anggota.kelola_anggota')
            ->with('edit', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = User::findOrFail($id);
        $anggota->delete();

        return redirect()->route('kelola_anggota.kelola_anggota')
            ->with('hapus', 'Data anggota berhasil dihapus.');
    }

    public function index_anggota()
    {
        // Carbon::setTestNow(Carbon::create(2025, 10, 20)); // ini buat ngecek bulan depan 
        $pengajuan = PengajuanPinjaman::where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->latest()
            ->first();

        $sisaCicilan = 0;
        $progress = 0;
        $bulanPinjam = 0;
        $tengat = null;

        if ($pengajuan) {
            $pelunasan = PelunasanPinjaman::where('pinjaman_id', $pengajuan->id)
                ->where('user_id', Auth::id())
                ->first();

            $totalPinjaman = $pengajuan->jumlah_harus_dibayar ?? 0;
            $totalDibayar  = $pelunasan->jumlah_dibayar ?? 0;
            $sisaCicilan   = max($totalPinjaman - $totalDibayar, 0);

            if ($totalPinjaman > 0) {
                $progress = round(($totalDibayar / $totalPinjaman) * 100, 2);
            }

            // ambil cicilan terakhir yang sudah dibayar
            $lastAngsuran = Angsuran::where('pinjaman_id', $pengajuan->id)
                ->where('status', 'sudah_bayar')
                ->orderByDesc('bulan_ke')
                ->first();

            $bulanPinjam = $lastAngsuran ? $lastAngsuran->bulan_ke : 0;

            // ambil angsuran berikutnya (belum dibayar) sebagai tenggat
            $nextAngsuran = Angsuran::where('pinjaman_id', $pengajuan->id)
                ->where('status', 'belum_bayar')
                ->orderBy('bulan_ke', 'asc')
                ->first();

            if ($nextAngsuran) {
                $tengat = Carbon::parse($nextAngsuran->tanggal_jatuh_tempo)->translatedFormat('d F Y');
            }

            if ($pelunasan && $pelunasan->status === 'lunas') {
                return view('anggota.index', [
                    'pengajuan'   => null,
                    'pelunasan'   => null,
                    'sisaCicilan' => 0,
                    'progress'    => 0,
                    'message'     => 'Pinjaman Anda sudah lunas.',
                    'bulanPinjam' => 0,
                    'tengat'      => null,
                    'statusTabungan' => null,
                ]);
            }
        }

        $bulanIni = Carbon::now()->format('Y-m');
        $tabunganWajib = TabWajib::where('user_id', Auth::id())
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->first();
        
        $tabunganManasuka = TabManasuka::where('user_id', Auth::id())
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->first();

        $statusTabunganManasuka = $tabunganManasuka
            ? ['status' => 'sudah', 'tanggal' => Carbon::parse($tabunganManasuka->tanggal)->translatedFormat('d F Y')]
            : ['status' => 'belum', 'tanggal' => Carbon::now()->translatedFormat('d F Y')];

        $statusTabungan = $tabunganWajib
            ? ['status' => 'sudah', 'tanggal' => Carbon::parse($tabunganWajib->tanggal)->translatedFormat('d F Y')]
            : ['status' => 'belum', 'tanggal' => Carbon::now()->translatedFormat('d F Y')];

        return view('anggota.index', compact('pengajuan', 'sisaCicilan', 'progress', 'bulanPinjam', 'tengat', 'statusTabungan', 'statusTabunganManasuka'));
    }


    public function profile()
    {
        $user = auth()->user();
        return view('anggota.profile_anggota.index', compact('user'));
    }

    public function identitas()
    {
        $user = auth()->user();
        $anggota = Datadiri::where('user_id', $user->id)->first();
        return view('anggota.profile_anggota.identitas', compact('user', 'anggota'));
    }

    public function dashboard()
    {
        return $this->index_anggota();
    }
}
