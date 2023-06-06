@extends('master')

@section('title', '')

@section('content')

<form method="post" action="{{ route('store-absensi') }}">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @csrf
    <input type="hidden" name="class_id" value="{{ $class->id }}">
    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" class="form-control" name="date" required>
        @if ($errors->has('date'))
        <div class="error">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('date') }}</p>
        </div>
        @endif
    </div>
    <div class="form-group">
        <table class="table table-bordered data-table display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th><label><input type="checkbox" id="santri-absensi-hadir" name="attendance" value="1" required>
                            Hadir</label></th>
                    <th><label><input type="checkbox" id="santri-absensi-izin" name="attendance" value="2" required>
                            Izin</label></th>
                    <th><label><input type="checkbox" id="santri-absensi-sakit" name="attendance" value="3" required>
                            Sakit</label></th>
                    <th><label><input type="checkbox" id="santri-absensi-alpha" name="attendance" value="4" required>
                            Alpha</label></th>
                </tr>
            </thead>
        </table>
        @if ($errors->has('attendance'))
        <div class="error">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('attendance') }}</p>
        </div>
        @endif
    </div>


    <div class="form-group">
        <label for="santri-keterangan">Keterangan:</label>
        <textarea class="form-control" name="ket"></textarea>
    </div>

    <div class="form-group" style="padding-top: 20px">
        <button type="submit" class="btn btn-info">Simpan</button>
    </div>
</form>










    @endsection

    @push('scripts')

    <script type="text/javascript">
        $( document ).ready(function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let checked = false;

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    checked = true;
                    checkboxes.forEach(function (checkbox) {
                        if (checkbox !== this) {
                            checkbox.disabled = true;
                        }
                    }, this);
                } else {
                    checked = false;
                    checkboxes.forEach(function (checkbox) {
                        checkbox.disabled = false;
                    });
                }
            });
        });

        function validateForm() {
            var checkboxes = document.getElementsByName("attendance");
            var isChecked = false;
            for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                isChecked = true;
                break;
            }
            }
            if (!isChecked) {
                alert("Mohon pilih minimal satu opsi pada kolom absensi.");
                return false;
            }
            return true;
        }


        $(function() {
                ('input[name="date"]').on('change', function() {
                var date = $(this).val();
                $.ajax({
                    url: '{{ route("check-absensi") }}',
                    method: 'GET',
                    data: { date: date, siswa_id: '{{ $siswa->id }}' },
                    success: function(data) {
                        if (data.length > 0) {
                            // Jika ada data, tampilkan tabel
                            var table = '<table class="table table-bordered data-table display nowrap" style="width:100%">';
                            table += '<thead><tr><th>Tanggal</th><th>Keterangan</th><th>Attendance</th></tr></thead>';
                            table += '<tbody>';
                            for (var i = 0; i < data.length; i++) {
                                table += '<tr>';
                                table += '<td>' + data[i].date + '</td>';
                                table += '<td>' + (data[i].keterangan ? data[i].keterangan : '-') + '</td>';
                                table += '<td>' + getAttendanceText(data[i].attendance) + '</td>';
                                table += '</tr>';
                            }
                            table += '</tbody></table>';
                            $('#absensi-table').html(table);
                        } else {
                            // Jika tidak ada data, kosongkan tabel
                            $('#absensi-table').html('');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memeriksa data absensi.');
                    }
                });
            });
        });

        function getAttendanceText(attendance) {
            switch (attendance) {
                case 1:
                    return 'Hadir';
                case 2:
                    return 'Izin';
                case 3:
                    return 'Sakit';
                case 4:
                    return 'Alpha';
                default:
                    return '-';
            }
        }

              // Jika form absensi disubmit
              $('#form-absensi').submit(function (e) {
            e.preventDefault(); // Mencegah form submit secara default

            // Ambil nilai dari input tanggal
            var dateValue = $('input[name="date"]').val();

            // Lakukan request AJAX ke server
            $.ajax({
                url: "{{ route('check-absensi') }}", // Ganti dengan route yang sesuai
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    date: dateValue
                },
                success: function (response) {
                    // Jika data sudah ada di database
                    if (response.length > 0) {
                        // Buat tabel untuk menampilkan data absensi
                        var table = '<table class="table table-bordered"><thead><tr><th>Tanggal</th><th>Keterangan</th><th>Status</th></tr></thead><tbody>';

                        // Tambahkan baris ke tabel untuk setiap data absensi
                        for (var i = 0; i < response.length; i++) {
                            table += '<tr><td>' + response[i].date + '</td><td>' + response[i].keterangan + '</td><td>' + response[i].status + '</td></tr>';
                        }

                        table += '</tbody></table>';

                        // Sisipkan tabel setelah form absensi
                        $('#form-absensi').after(table);
                    }

                    // Submit form absensi
                    $('#form-absensi')[0].submit();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
    </script>

    @endpush
