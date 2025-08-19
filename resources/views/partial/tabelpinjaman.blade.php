<div class="mt-2 max-w-full overflow-x-auto">
    <table class="min-w-full text-left border border-gray-700 rounded-lg">
        <thead class="bg-gray-800 text-gray-100">
            <tr>
                <th class="px-4 py-2">Nama Pemohon</th>
                <th class="px-4 py-2">Nominal Pinjaman</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 text-gray-100 divide-y divide-gray-700">
            @foreach($pengajuan as $item)
                <tr class="hover:bg-gray-700">
                    <td class="px-4 py-2">{{ $item->user->name }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        <span class="@if($item->status == 'aktif') text-green-400 @elseif($item->status == 'penting') text-yellow-400 @else text-gray-400 @endif font-semibold">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
