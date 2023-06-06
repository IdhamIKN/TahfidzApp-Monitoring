@extends('master')

@section('title', '')

@section('content')

<form method="post" action="{{ route('store-parent') }}">

    @csrf

    <div class="form-group">
        <label>Orangtua Dari</label>
        <select class="js-example-basic-single form-control" id="siswa_data" name="siswa_data[]" style="width: 100%"
            multiple="multiple"></select>
        @if ($errors->has('teacher_id'))
        <div class="error">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('teacher_id') }}</p>
        </div>
        @endif
    </div>

    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" value="{{ old('') }}" name="username">
        @if ($errors->has('username'))
        <div class="error">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('username') }}</p>
        </div>
        @endif
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" value="{{ old('full_name') }}" name="full_name">
        @if ($errors->has('full_name'))
        <div class="email">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('full_name') }}</p>
        </div>
        @endif
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" value="{{ old('email') }}" name="email">
        @if ($errors->has('username'))
        <div class="email">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('email') }}</p>
        </div>
        @endif
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea class="form-control" placeholder="" rows="3" name="address">{{ old('address') }}</textarea>
        @if ($errors->has('address'))
        <div class="address">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('address') }}</p>
        </div>
        @endif
    </div>

    <div class="form-group col-md-6" style="padding-left: 0px" hidden>
        <label>Password</label>
        <input type="text" class="form-control" value="" name="password">
        @if ($errors->has('password'))
        {{-- <div class="password">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('password') }}</p>
        </div> --}}
        @endif
    </div>

    <div class="form-group col-md-6" style="padding-left: 0px" hidden>
        <label>Re Password</label>
        <input type="text" class="form-control" value="" name="password_confirmation">
        @if ($errors->has('password'))
        {{-- <div class="password">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('password') }}</p>
        </div> --}}
        @endif
    </div>

    <div style="text-align: right; font-size: 12px; margin-top: 20px;">
        {{ "* Untuk login Orang Tua menggunakan NIS dan Password juga Menggunakan NIS"}}
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-info"> TAMBAH </button>
    </div>

</form>

@endsection

@push('scripts')
{{-- <script type="text/javascript">
    $(document).ready(function() {
	    $('#siswa_data').select2({
	    	allowClear: true,
			placeholder: 'Masukkan Nama Siswa',
			ajax: {
				url: base_url + '/parent/get-siswa',
				dataType: 'json',
				data: function(params) {
				    return {
				      search: params.term
				    }
				},
				processResults: function (data, page) {
				    return {
				        results: data
				    };
				}
			}
	    });
	});
</script> --}}


<script type="text/javascript">
    $(document).ready(function() {
        $('#siswa_data').select2({
            allowClear: true,
            placeholder: 'Masukkan Nama Siswa',
            ajax: {
                url: base_url + '/parent/get-siswa',
                dataType: 'json',
                data: function(params) {
                    return {
                      search: params.term
                    }
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                }
            }
        });

        $('#siswa_data').on('change', function() {
            var siswa_data = $('#siswa_data').select2('data');
            if (siswa_data.length > 0) {
                var nis = siswa_data[0].text.split(' - ')[0]; // ambil NIS dari teks siswa yang dipilih
                $('input[name="username"]').val(nis).prop('disabled', false); // isi dan disable field username dengan NIS
                $('input[name="password"]').val(nis); // Mengisi kolom password dengan NIS
                $('input[name="password_confirmation"]').val(nis); // Mengisi kolom re-password dengan NIS
            } else {
                $('input[name="username"]').val('').prop('disabled', true); // reset dan enable field username jika tidak ada siswa yang dipilih
                $('input[name="password"]').val(''); // Mengosongkan kolom password
                $('input[name="password_confirmation"]').val(''); // Mengosongkan kolom re-password
            }
        });
    });



</script>









@endpush
