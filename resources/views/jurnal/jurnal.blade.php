<!DOCTYPE html>
<html>

<head>
    <title>Agenda dan Jurnal Ustadz/Ustadzah {{ $user->username }} Griya Tahfidz Al-Quran Al-Haromain</title>
    <style>
        /* CSS untuk styling kop halaman */
        .kop {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .kop p {
            font-size: 12px;
            margin-bottom: 0;
        }

        /* CSS untuk styling isi jurnal */
        .jurnal {
            font-size: 14px;
        }

        .jurnal table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .jurnal th,
        .jurnal td {
            border: 1px solid black;
            padding: 5px;
        }

        /* CSS untuk mengatur tampilan jurnal dalam mode cetak */
        @media print {

            /* Mengatur kertas menjadi landscape */
            @page {
                size: landscape;
            }
        }

        /* CSS untuk mengatur judul menjadi tengah */
        .jurnal h3 {
            text-align: center;
        }

        .jurnal h4 {
            text-align: center;
        }

        /* CSS untuk mengatur lebar kolom materi, indikator, dan pencapaian */
        .jurnal th:nth-child(2),
        .jurnal th:nth-child(6),
        .jurnal td:nth-child(2),
        .jurnal td:nth-child(6) {
            width: 150px;
        }

        .jurnal th:nth-child(4),
        .jurnal td:nth-child(4) {
            width: 200px;
        }

        /* CSS untuk mengatur posisi logo 1 dan logo 2 pada kop */


        .logo img {
            height: 120px;
            width: 120px;
            margin-right: 10px;
            /* menambahkan margin kanan antara logo kiri dan kanan */
        }

        #table_style {
            font-family: DejaVu Sans, sans-serif;
            border-collapse: collapse;
            width: 100%;
            padding-top: 10px;
        }

        #table_style td,
        #table_style th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table_style tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table_style tr:hover {
            background-color: #ddd;
        }

        #table_style th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <div class="kop">
        <div class="logo">
        </div>
        <div class="konten">
            <div style="text-align: center; line-height: 0.2;">
                <div class="kop">
                    <h2>Griya Tahfidz Al-Quran Al-Haromain</h2>
                    <p>Jalan Raya Madigondo Kejamulya, Sambirejo, Jiwan, Madiun.</p>
                    <p>Telp. 085-175-021-381 | Website: https://griyatahfidz.bmdsyariah.com/</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="jurnal">
        <h3>Agenda dan Jurnal <br> Ustadz/Ustadzah {{ $user->username }}</h3>
        <h4>Bulan {{ date('F Y', strtotime($data[0]->jampel)) }}</h4>
        <table>
            <tr>
                @if($user->account_type == User::ACCOUNT_TYPE_ADMIN || $user->account_type ==
                User::ACCOUNT_TYPE_CREATOR)
                <th>Ustadz / Ustadzah</th>
                @endif
                <th>Kelas</th>
                <th>Pertemuan / JamPel</th>
                <th style="width: 200px;">Materi</th>
                <th style="width: 200px;">Indikator</th>
                <th style="width: 200px;">Pencapaian</th>
                <th>Kehadiran</th>
            </tr>
            <!-- Data jurnal dapat diisi di bawah ini -->
            @foreach($data as $jurnal)
            <tr>
                @if($user->account_type == User::ACCOUNT_TYPE_ADMIN || $user->account_type ==
                User::ACCOUNT_TYPE_CREATOR)
                <td>{{ $jurnal->user->username }}</td>
                @endif
                <td>{{ $jurnal->studentClass->class_name }} - {{ $jurnal->studentClass->angkatan }}</td>
                <td>{{ $jurnal->pertemuan }} / {{ date('H:i d-m-Y', strtotime($jurnal->jampel)) }}</td>
                <td>{{ $jurnal->materi }}</td>
                <td>{{ $jurnal->indikator }}</td>
                <td>{{ $jurnal->pencapaian }}</td>
                <td>{{ $jurnal->kehadiran }}</td>
            </tr>
            @endforeach
            <!-- Tambahkan baris data jurnal sesuai kebutuhan -->
        </table>
        <div style="text-align: right; font-size: 12px; margin-top: 20px;">
            {{ "Di Cetak " . date('H:i d-m-Y') }}
        </div>
    </div>


</body>

</html>
