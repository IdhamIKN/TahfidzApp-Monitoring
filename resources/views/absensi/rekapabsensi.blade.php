<!DOCTYPE html>
<html>

<head>
    <title>Rekap Aabsensi Santri/Santriwati Kelas {{ $class_id->class_name }}</title>
</head>
<style>
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

<body>
    <div style="text-align: center; line-height: 0.2;">
        <div class="kop">
            <h2>Griya Tahfidz Al-Quran Al-Haromain</h2>
            <p>Jalan Raya Madigondo Kejamulya, Sambirejo, Jiwan, Madiun.</p>
            <p>Telp. 085-175-021-381 | Website: https://griyatahfidz.bmdsyariah.com/</p>
        </div>
    </div>
    <hr>
    <div style="text-align: center; line-height: 0.2;">
        <p>
            <h4>Laporan Rekap Absensi Santri / Santriwati Kelas {{ $class_id->class_name }}</h4>
            @if(session('month'))
                <p>Periode Bulan {{ date('F Y', strtotime(session('month'))) }}</p>
            @endif
        <p>
    </div>
    <table id="table_style">
        <thead>
            {{-- <tr class="text-center bg-light" style="font-weight: bold;line-height: 1;">
                <td colspan="2" style="vertical-align : middle;width: 10px;">Data</td>
                <td colspan="4" style="vertical-align : middle;width: 10px;">Kehadiran</td>
                <td rowspan="2" style="vertical-align : middle; white-space: normal; width:50px; text-align: center;">
                    TOTAL
                </td>
            </tr> --}}
            <tr>
                <th style="vertical-align : middle; text-align: center;">No</th>
                <th style="vertical-align : middle; text-align: center;">Nama</th>
                <th style="vertical-align : middle; text-align: center;">H</th>
                <th style="vertical-align : middle; text-align: center;">I</th>
                <th style="vertical-align : middle; text-align: center;">S</th>
                <th style="vertical-align : middle; text-align: center;">A</th>
                <th style="vertical-align : middle; text-align: center;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $key => $santri)
            <?php $hadir = 0; $izin = 0; $sakit = 0; $alpha = 0; ?>
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $santri->siswa_name }}</td>
                @foreach ($absenSiswa as $absen)
                @if ($absen->siswa_id == $santri->id)
                @if ($absen->attendance == 1)
                <?php $hadir++ ?>
                @elseif ($absen->attendance == 2)
                <?php $izin++ ?>
                @elseif ($absen->attendance == 3)
                <?php $sakit++ ?>
                @elseif ($absen->attendance == 4)
                <?php $alpha++ ?>
                @endif
                @endif
                @endforeach
                <td>{{ $hadir }}</td>
                <td>{{ $izin }}</td>
                <td>{{ $sakit }}</td>
                <td>{{ $alpha }}</td>
                <td>{{ $hadir }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: right; font-size: 12px; margin-top: 20px;">
        {{ "Di Cetak " . date('H:i d-m-Y') }}
    </div>
</body>

</html>
