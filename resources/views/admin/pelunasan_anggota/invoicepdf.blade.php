<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Pelunasan Pinjaman</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
      margin: 20px;
    }
    .header {
      text-align: center;
      margin-bottom: 10px;
    }
    .header h2 {
      margin: 0;
      font-size: 16px;
    }
    .header p {
      margin: 2px 0;
      font-size: 10px;
    }
    .title {
      text-align: center;
      font-size: 13px;
      margin: 10px 0;
      font-weight: bold;
      text-transform: uppercase;
      text-decoration: underline;
    }
    .info-table, .details-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .info-table td {
      padding: 4px;
    }
    .details-table th, .details-table td {
      border: 1px solid #000;
      padding: 6px;
    }
    .details-table th {
      background-color: #f2f2f2;
      text-align: left;
    }
    .footer {
      margin-top: 30px;
      text-align: right;
      font-size: 10px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>KOPERASI SMPN 1 CISARUA</h2>
    <p>Jl. Kolonel Masturi No.312, Kertawangi, Cisarua, Bandung Barat 40551</p>
  </div>

  <div class="title">Bukti Pelunasan Pinjaman</div>

  <table class="info-table">
    <tr>
      <td><strong>No. Bukti</strong></td>
      <td>: {{ $invoiceId }}</td>
    </tr>
    <tr>
      <td><strong>Nama Peminjam</strong></td>
      <td>: {{ $nama }}</td>
    </tr>
    <tr>
      <td><strong>Jenis Kredit</strong></td>
      <td>: {{ $jenis_kredit }}</td>
    </tr>
    <tr>
      <td><strong>Tanggal Bayar</strong></td>
      <td>: {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</td>
    </tr>
    <tr>
      <td><strong>Metode Pembayaran</strong></td>
      <td>: {{ $metode }}</td>
    </tr>
  </table>

  <table class="details-table">
    <tr>
      <th>Deskripsi</th>
      <th>Jumlah</th>
    </tr>
    <tr>
      <td>Pokok</td>
      <td>Rp{{ number_format($pokok, 2, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Bunga</td>
      <td>Rp{{ number_format($bunga, 2, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>{{ $keterangan }}</td>
    </tr>
    <tr>
      <th>Total Angsuran</th>
      <th>Rp{{ number_format($total_angsuran, 2, ',', '.') }}</th>
    </tr>
  </table>

  <div class="footer">
    <p>Petugas Koperasi</p>
    <br><br>
    <p>(........................................)</p>
  </div>
</body>
</html>
