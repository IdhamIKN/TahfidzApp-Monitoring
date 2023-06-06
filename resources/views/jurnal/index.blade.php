@extends('master')

@section('title', '')

@section('alert')

@if(Session::has('alert_success'))
@component('components.alert')
@slot('class')
success
@endslot
@slot('title')
Terimakasih
@endslot
@slot('message')
{{ session('alert_success') }}
@endslot
@endcomponent
@elseif(Session::has('alert_error'))
@component('components.alert')
@slot('class')
error
@endslot
@slot('title')
Cek Kembali
@endslot
@slot('message')
{{ session('alert_error') }}
@endslot
@endcomponent
@endif

@endsection

@section('content')

<form method="post" action="{{route('store-jurnal')}}">

    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Pertemuan Ke</label>
                <input type="text" class="form-control" value="" name="pertemuan">
                @if ($errors->has('pertemuan'))
                <div class="error">
                    <p style="color: red"><span>&#42;</span> {{ $errors->first('pertemuan') }}</p>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Jam Pelajaran</label>
                <input type="datetime-local" class="form-control" value="" name="jampel">
                @if ($errors->has('jampel'))
                <div class="error">
                    <p style="color: red"><span>&#42;</span> {{ $errors->first('jampel') }}</p>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Kelas </label>
                <select class="js-example-basic-single form-control" name="class" id="class" style="width: 100%">
                  <option></option>
                </select>
                @if ($errors->has('class'))
                    <div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('class') }}</p></div>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Materi</label>
        <textarea class="form-control" placeholder="" rows="3" id="materi" name="materi"></textarea>
    </div>

    <div class="form-group">
        <label>Indikator</label>
        <textarea class="form-control" placeholder="" rows="3" id="indikator" name="indikator"></textarea>
    </div>

    <div class="form-group">
        <label>Pencapaian</label>
        <textarea class="form-control" placeholder="" rows="3" id="pencapaian" name="pencapaian"></textarea>
    </div>

    <div class="form-group">
        <label>Kehadiran Santri</label>
        <input type="text" class="form-control" value="" name="kehadiran">
        @if ($errors->has('kehadiran'))
        <div class="error">
            <p style="color: red"><span>&#42;</span> {{ $errors->first('kehadiran') }}</p>
        </div>
        @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-info"> KIRIM </button>
    </div>

</form>

<hr>

@endsection



@push('scripts')

<script type="text/javascript">
    var idjurnal;
    var table;
    $(function () {
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                "aaSorting": [[ 2, "desc" ]],
                ajax: "{{ route('jurnal') }}",
                columns: [
                {data: 'pertemuan', name: 'pertemuan'},
                {data: 'pencapaian', name: 'pencapaian'},
                {data: 'kehadiran', name: 'kehadiran'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $(document).ready(function() {
		$('#class').select2({
			allowClear: true,
			ajax: {
			  url: base_url + '/siswa/get-class',
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
    });

    function btnDel(id){
        idjurnal = id;

        swal({
            title: "Menghapus Jurnal Pembelajaran",
            text: 'Jurnal yang telah di hapus tidak dapat dikembalikan',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            $.ajax({
                type:'POST',
                url: base_url + '/jurnal/delete ',
                data:{
                idjurnal:idjurnal,
                "_token": "{{ csrf_token() }}",},
                success:function(data) {

                if(data.status != false)
                {
                    swal(data.message, { button:false, icon: "success", timer: 1000});
                }
                else
                {
                    swal(data.message, { button:false, icon: "error", timer: 1000});
                }
                table.ajax.reload();
                },
                error: function(error) {
                swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
                }
            });
            }
        });
    }

    function btnUbah(id)
    {
    idjurnal = id;
    $.ajax({
        type:'POST',
        url: base_url + '/jurnal/get-detail',
        data:{idjurnal:idjurnal, "_token": "{{ csrf_token() }}",},
        success:function(data) {
            $('#detailModal').modal('toggle');
            $('#jampel').val(jampel);
            $('#pertemuan').val(pertemuan);
            $('#materi').val(materi);
            $('#indikator').val(indikator);
            $('#pencapaian').val(pencapaian);
            $('#kehadiran').val(kehadiran);
        }
    });

    $('#hapus_action').click(function() {
        hapus(idjurnal);
        $("#detailModal .close").click()
    })

    $('#update_data').click(function() {

        var jampel = $('#jampel').val();
        var pertemuan = $('#pertemuan').val();
        var materi = $('#materi').val();
        var indikator = $('#indikator').val();
        var pencapaian = $('#pencapaian').val();
        var kehadiran = $('#kehadiran').val();

        $.ajax({
        type:'POST',
        url: base_url + '/jurnal/update',
        data:{
                idjurnal:idjurnal,
                "_token": "{{ csrf_token() }}",
                jampel: jampel,
                pertemuan: pertemuan,
                materi: materi,
                indikator: indikator,
                pencapaian: pencapaian,
                kehadiran: kehadiran
        },
        success:function(data) {
            if(data.status != false)
            {
            swal(data.message, { button:false, icon: "success", timer: 1000});
            $("#detailModal .close").click()
            }
            else
            {
            swal(data.message, { button:false, icon: "error", timer: 1000});
            }
            table.ajax.reload();
        },
        error: function(error) {
            swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
        }
        });
    })

    }


</script>
@endpush
