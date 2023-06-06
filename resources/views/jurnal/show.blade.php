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
        <div class="col-md-6">
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
        <div class="col-md-6">
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

<div class="table-responsive">
    <table class="table table-bordered data-table display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Hari/tanggal</th>
                <th>Pertemuan Ke</th>
                <th>Materi</th>
                <th>Indikator</th>
                <th>Pencapaian</th>
                <th>Kehadiran</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection

@section('modal')

<div class="modal fade" id="detailModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p class="modal-title">Detail Jurnal</p>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right" id="hapus_action">Hapus</button>
                <button type="button" id="update_data" class="btn btn-default pull-left">Update</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
    var id;
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
                {data: 'jampel', name: 'jampel'},
                {data: 'pertemuan', name: 'pertemuan'},
                {data: 'materi', name: 'materi'},
                {data: 'indikator', name: 'indikator'},
                {data: 'pencapaian', name: 'pencapaian'},
                {data: 'kehadiran', name: 'kehadiran'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });

    function btnUbah(idjurnal){
  idjurnal = id;
  $.ajax({
     type:'POST',
     url: base_url + '/get-detail',
     data:{id:id, "_token": $('meta[name="csrf-token"]').attr('content')},
     success:function(data) {
        $('#detailModal').modal('toggle');
        $('#jampel').val(data.data.jampel);
        $('#pertemuan').val(data.data.pertemuan);
        $('#materi').val(data.data.materi);
        $('#indikator').val(data.data.indikator);
        $('#pencapaian').val(data.data.pencapaian);
        $('#kehadiran').val(data.data.kehadiran);
     }
  });

  $('#hapus_action').click(function() {
    hapus(id);
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
            "_token": $('meta[name="csrf-token"]').attr('content'),
            jampel : jampel,
            pertemuan : pertemuan,
            materi : materi,
            indikator : indikator,
            pencapaian : pencapaian,
            kehadiran : kehadiran
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


    function hapus(idjurnal){
        swal({
            title: "Menghapus",
            text: 'Apakah anda yakin ingin menghapus ini ?',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            $.ajax({
                type:'POST',
                url: base_url + '/jurnal/delete',
                data:{
                idsurah:idsurah,
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


</script>

@endpush
