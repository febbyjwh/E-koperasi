<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datadiri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DatadiriController extends Controller
{
    public function store(Request $request)
    {
        $existing = Datadiri::where('user_id', Auth::id())->first();

        $rules = [
            'foto_ktp' => [$existing ? 'required' : 'required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('datadiris', 'nik')->ignore($existing?->id),
            ],
            'nama_pengguna' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('datadiris', 'email')->ignore($existing?->id),
            ],
            'no_wa' => 'required|string|max:15',
            'alamat' => 'required|string',

            'no_anggota' => [
                'required',
                'string',
                'max:50',
                Rule::unique('datadiris', 'no_anggota')->ignore($existing?->id),
            ],
            'nip' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'unit_kerja' => 'required|string|max:100',
            'tanggal_mulai_kerja' => 'required|date',
            'status_kepegawaian' => 'required|string|max:50',
            'tanggal_bergabung' => 'required|date',
            'status_keanggotaan' => 'required|string|max:50',

            'nama_keluarga' => 'required|string|max:255',
            'hubungan_keluarga' => 'required|string|max:50',
            'nomor_telepon_keluarga' => 'required|string|max:15',
            'alamat_keluarga' => 'required|string',
        ];

        $validated = $request->validate($rules);

        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $validated['user_id'] = Auth::id();

        if ($existing) {
            $existing->update($validated);
        } else {
            Datadiri::create($validated);
        }

        return redirect()
            ->route('profile_anggota.identitas')
            ->with('success', 'Data diri berhasil disimpan.');
    }
}
