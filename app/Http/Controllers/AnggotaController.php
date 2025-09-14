<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Datadiri;
use App\Models\PelunasanPinjaman;
use App\Models\PengajuanPinjaman;
use App\Models\TabManasuka;
use App\Models\TabWajib;
use App\Models\User;
// use App\Models\Datadiri;
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
            'username' => 'required|string|max:50|unique:users,username|lowercase',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $password = $request->username . '123';

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password' => Hash::make($password), // Default password
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
        $userId = Auth::id();

        // Ambil pengajuan pinjaman aktif
        $pengajuan = PengajuanPinjaman::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->latest()
            ->first();

        $sisaCicilan = 0;
        $progress = 0;
        $bulanPinjam = 0;
        $tengat = null;
        $nominalCicilanBulanIni = 0;

        if ($pengajuan) {
            // Ambil pelunasan jika ada
            $pelunasan = PelunasanPinjaman::where('pinjaman_id', $pengajuan->id)
                ->where('user_id', $userId)
                ->first();

            $totalPinjaman = $pengajuan->jumlah_harus_dibayar ?? 0;
            $totalDibayar  = $pelunasan->jumlah_dibayar ?? 0;
            $sisaCicilan   = max($totalPinjaman - $totalDibayar, 0);

            if ($totalPinjaman > 0) {
                $progress = round(($totalDibayar / $totalPinjaman) * 100, 2);
            }

            // Cicilan terakhir yang sudah dibayar
            $lastAngsuran = Angsuran::where('pinjaman_id', $pengajuan->id)
                ->where('status', 'sudah_bayar')
                ->orderByDesc('bulan_ke')
                ->first();

            // Cicilan berikutnya yang belum dibayar
            $nextAngsuran = Angsuran::where('pinjaman_id', $pengajuan->id)
                ->where('status', 'belum_bayar')
                ->orderBy('bulan_ke', 'asc')
                ->first();

            if ($nextAngsuran) {
                $bulanPinjam = $nextAngsuran->bulan_ke; // bulan cicilan berikutnya
                $nominalCicilanBulanIni = $nextAngsuran->total_angsuran; // gunakan total_angsuran
                $tengat = Carbon::parse($nextAngsuran->tanggal_jatuh_tempo)->translatedFormat('d F Y');
            } else {
                // Jika sudah lunas semua cicilan
                $bulanPinjam = $lastAngsuran ? $lastAngsuran->bulan_ke + 1 : 1;
                $nominalCicilanBulanIni = 0;
                $tengat = null;
            }

            // Jika sudah lunas total
            if ($pelunasan && $pelunasan->status === 'lunas') {
                return view('anggota.index', [
                    'pengajuan' => null,
                    'pelunasan' => null,
                    'sisaCicilan' => 0,
                    'progress' => 0,
                    'message' => 'Pinjaman Anda sudah lunas.',
                    'bulanPinjam' => 0,
                    'tengat' => null,
                    'nominalCicilanBulanIni' => 0,
                    'statusTabungan' => null,
                    'statusTabunganManasuka' => null,
                    'tabunganWajibTotal' => 0,
                    'tabunganManasukaTotal' => 0,
                ]);
            }
        }

        // Ambil bulan ini
        $bulanIni = Carbon::now()->format('Y-m');

        // Hitung total tabungan wajib bulan ini
        $tabunganWajibTotal = TabWajib::where('user_id', $userId)
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->sum('nominal');

        $statusTabungan = $tabunganWajibTotal > 0
            ? ['status' => 'sudah', 'tanggal' => Carbon::parse(
                TabWajib::where('user_id', $userId)
                    ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
                    ->latest('tanggal')
                    ->first()->tanggal
            )->translatedFormat('d F Y')]
            : ['status' => 'belum', 'tanggal' => Carbon::now()->translatedFormat('d F Y')];

        // Hitung total tabungan manasuka bulan ini
        $tabunganManasukaTotal = TabManasuka::where('user_id', $userId)
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->sum('nominal_masuk');

        $statusTabunganManasuka = $tabunganManasukaTotal > 0
            ? ['status' => 'sudah', 'tanggal' => Carbon::parse(
                TabManasuka::where('user_id', $userId)
                    ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
                    ->latest('tanggal')
                    ->first()->tanggal
            )->translatedFormat('d F Y')]
            : ['status' => 'belum', 'tanggal' => Carbon::now()->translatedFormat('d F Y')];

        return view('anggota.index', compact(
            'pengajuan',
            'sisaCicilan',
            'progress',
            'bulanPinjam',
            'tengat',
            'nominalCicilanBulanIni',
            'statusTabungan',
            'statusTabunganManasuka',
            'tabunganWajibTotal',
            'tabunganManasukaTotal'
        ));
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

    public function show($id)
    {
        // cari user berdasarkan id
        $anggota = User::with('datadiri')->findOrFail($id);

        return view('admin.kelola_anggota.show', compact('anggota'));
    }
}
