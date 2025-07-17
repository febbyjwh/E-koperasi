<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Pencairan Dana</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
      margin: 30px;
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .header h2 {
      margin: 0;
      font-size: 18px;
    }
    .header p {
      margin: 2px 0;
      font-size: 11px;
    }
    .title {
      text-align: center;
      font-size: 14px;
      margin: 10px 0;
      font-weight: bold;
      text-transform: uppercase;
      text-decoration: underline;
    }
    .info, .details {
      width: 100%;
      margin-top: 10px;
      border-collapse: collapse;
    }
    .info td {
      padding: 5px;
      vertical-align: top;
    }
    .details th, .details td {
      border: 1px solid #000;
      padding: 8px;
    }
    .details th {
      background-color: #f2f2f2;
      text-align: left;
    }
    .footer {
      margin-top: 40px;
      text-align: right;
      font-size: 11px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>KOPERASI SMPN 1 CISARUA</h2>
    <p>Jl. Kolonel Masturi No.312, Kertawangi, Kec. Cisarua</p>
    <p>Kabupaten Bandung Barat, Jawa Barat 40551</p>
  </div>

  <div class="title">Bukti Pencairan Dana</div>

  @php
    $invoiceId = 'PINDA' . str_pad($pinjaman->id, 3, '0', STR_PAD_LEFT) . '-' . $tanggal->format('dmY');
  @endphp

  <table style="width: 100%; font-size: 12px; line-height: 1.2; margin-top: 5px;">
    <tr>
      <td style="width: 150px; padding: 2px 0;"><strong>No. Bukti</strong></td>
      <td>: {{ $invoiceId }}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0;"><strong>Tanggal</strong></td>
      <td>: {{ $tanggal->format('d-m-Y') }} ({{ $tanggal->format('H:i') }})</td>
    </tr>
    <tr>
      <td style="padding: 2px 0;"><strong>Nama Peminjam</strong></td>
      <td>: {{ $nama }}</td>
    </tr>
    <tr>
      <td style="padding: 2px 0;"><strong>Metode Pembayaran</strong></td>
      <td>: Tunai</td>
    </tr>
  </table>

  <table class="details">
    <tr>
      <th>Deskripsi</th>
      <th>Jumlah</th>
    </tr>
    <tr>
      <td>Dana Pinjaman</td>
      <td>Rp{{ number_format($jumlah_pinjaman, 2, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Propisi ({{ number_format(($propisi / $jumlah_pinjaman) * 100) }}%)</td>
      <td>Rp{{ number_format($propisi, 2, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Jenis Pinjaman</td>
      <td>Kredit {{ $jenis_pinjaman }}</td>
    </tr>
    <tr>
      <td>Tenor</td>
      <td>{{ $lama_angsuran }} bulan</td>
    </tr>
    <tr>
      <td>Status Pencairan Dana</td>
      <td>{{ ucfirst($status_konfirmasi) }}</td>
    </tr>
    <tr>
      <th><strong>Total Dana Diterima</strong></th>
      <th><strong>Rp{{ number_format($jumlah_diterima, 2, ',', '.') }}</strong></th>
    </tr>
  </table>

  <div class="footer">
    <p>Petugas Koperasi</p>
    <br><br><br>
    <p>(........................................)</p>
  </div>
</body>
</html>
