@extends('master')

@section('title', '')

@section('content')

<label for="month" class="col-form-label">Cari Berdasarkan Bulan</label>
<form action="{{ route('search-absensi') }}" method="POST" id="search-form">
    @csrf
    <div class="form-group row">

        <div class="col-sm-3">
            <input type="month" class="form-control" id="month" name="month" required>
        </div>
        <div class="col-sm-1">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </div>
    <input type="hidden" name="class_id" value="{{ $class->id }}">
</form>
<br>
<div id="search-result" style="display: none;">
    <span id="table-title">Data Absensi</span>
    <table class="table table-bordered data-table display nowrap" style="width:100%">
        <thead>
            <tr class="text-center bg-light" style="font-weight: bold;line-height: 1;">
                <td colspan="3" style="vertical-align : middle;width: 10px;">Data</td>
                <td colspan="4" style="vertical-align : middle;width: 10px;">Kehadiran</td>
                <td rowspan="2" style="vertical-align : middle; white-space: normal; width:50px; text-align: center;">
                    TOTAL
                </td>
                <td rowspan="2" style="vertical-align : middle; white-space: normal; width:50px; text-align: center;">
                    Aksi
                </td>
            </tr>
            <tr>
                <th style="vertical-align : middle; text-align: center;">No</th>
                <th style="vertical-align : middle; text-align: center;">Nama</th>
                <th style="vertical-align : middle; text-align: center;">Keterangan</th>
                <th style="vertical-align : middle; text-align: center;">Hadir</th>
                <th style="vertical-align : middle; text-align: center;">Izin</th>
                <th style="vertical-align : middle; text-align: center;">Sakit</th>
                <th style="vertical-align : middle; text-align: center;">Alpha</th>
            </tr>
        </thead>
        <tbody id="search-result-body">
        </tbody>
    </table>
</div>



<table class="table table-bordered data-table display nowrap" style="width:100%">
    <thead>
        <tr class="text-center bg-light" style="font-weight: bold;line-height: 1;">
            <td colspan="3" style="vertical-align : middle;width: 10px;">Data</td>
            <td colspan="4" style="vertical-align : middle;width: 10px;">Kehadiran</td>
            <td rowspan="2" style="vertical-align : middle; white-space: normal; width:50px; text-align: center;">TOTAL
            </td>
            <td rowspan="2" style="vertical-align : middle; white-space: normal; width:50px; text-align: center;">Aksi
            </td>
        </tr>
        <tr>
            <th style="vertical-align : middle; text-align: center;">No</th>
            <th style="vertical-align : middle; text-align: center;">Nama</th>
            <th style="vertical-align : middle; text-align: center;">Keterangan</th>
            <th style="vertical-align : middle; text-align: center;">Hadir</th>
            <th style="vertical-align : middle; text-align: center;">Izin</th>
            <th style="vertical-align : middle; text-align: center;">Sakit</th>
            <th style="vertical-align : middle; text-align: center;">Alpha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $key => $santri)
        <?php $hadir = 0; $izin = 0; $sakit = 0; $alpha = 0; ?>
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $santri->siswa_name }}</td>
            <td>
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
            </td>
            <td>{{ $hadir }}</td>
            <td>{{ $izin }}</td>
            <td>{{ $sakit }}</td>
            <td>{{ $alpha }}</td>
            <td>{{ $hadir }}</td>
            <td>
                <a href="{{ route('absensi.edit', [$santri->id]) }}" class="btn btn-info">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection

@push('scripts')
<script>
    // Mencegah form submit pada saat page load
    $('#search-form').submit(function(e) {
            e.preventDefault();
    });

    // Fungsi untuk menampilkan data absensi berdasarkan bulan yang dipilih
    function searchAbsensi() {
        var class_id = $('#class_id').val();
        var month = $('#month').val();
        if (class_id != '' && month != '') {
            $.ajax({
                url: '{{ route("search-absensi") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    class_id: class_id,
                    month: month
                },
                success: function(data) {
                    $('#search-result-body').html(data);
                    $('#search-result').show();
                },
                error: function(xhr) {
                    alert(xhr.responseText);
                }
            });
        }
    }

    // Event listener ketika tombol "
    $('#search-button').click(function(e) {
        e.preventDefault();

        // Ambil nilai input bulan
        var month = $('input[name="month"]').val();

        // Validasi input bulan
        if (month === '') {
          alert('Silakan pilih bulan terlebih dahulu');
          return false;
        }
        e.preventDefault();

        // Ambil nilai input bulan
        var month = $('input[name="month"]').val();

        // Validasi input bulan
        if (month === '') {
            lert('Silakan pilih bulan terlebih dahulu');
                return false;
            }

        // Kirim permintaan ajax ke server
        $.ajax({
            url: '{{ route("search-absensi") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                class_id: '{{ $class->id }}',
                month: month
            },
            success: function(data) {
                // Tampilkan hasil pencarian
                $('#search-result').html(data);
                $('#search-result').show();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
      // tambahkan event listener pada input tanggal
      $('input[name="date"]').on('change', function() {
        var siswa_id = $('input[name="siswa_id"]').val();
        var class_id = $('input[name="class_id"]').val();
        var date = $(this).val();

        // panggil fungsi ajax untuk mengambil data absensi
        getAbsensiData(siswa_id, class_id, date);
      });

      function getAbsensiData(siswa_id, class_id, date) {
        $.ajax({
          url: '/absensi/getData',
          type: 'GET',
          data: {
            siswa_id: siswa_id,
            class_id: class_id,
            date: date
          },
          dataType: 'json',
          success: function(data) {
            if (data.success) {
              // isi data ke dalam form
              $('input[name="attendance"][value="' + data.attendance + '"]').prop('checked', true);
              $('textarea[name="ket"]').val(data.ket);
            } else {
              // kosongkan form
              $('input[name="attendance"]').prop('checked', false);
              $('textarea[name="ket"]').val('');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        });
      }
    });
</script>





@endpush
