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
<form method="GET" action="{{ route('jurnal-search') }}">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <input type="month" class="form-control" id="month" name="month" required>
            </div>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(session('jurnal_data') && count(session('jurnal_data')) > 0)
            <a href="{{ route('printjurnal') }}" class="btn btn-success" target="_blank">
                <span class="glyphicon glyphicon-print"></span>Cetak </a>
            @endif
        </div>
    </div>
</form>
<br>
<div class="table-responsive">
    <table class="table table-bordered data-table display nowrap table-hover" style="width:100%">
        <thead>
            <tr>
                @if($user->account_type == User::ACCOUNT_TYPE_ADMIN || $user->account_type ==
                User::ACCOUNT_TYPE_CREATOR)
                <th>Ustadz/Ustadzah</th>
                @endif
                <th>Pertemuan</th>
                <th>Kelas</th>
                <th>Pencapaian</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $jurnal)
            <tr>
                @if($user->account_type == User::ACCOUNT_TYPE_ADMIN || $user->account_type ==
                User::ACCOUNT_TYPE_CREATOR)
                <td>{{ $jurnal->user->username }}</td>
                @endif
                <td>{{ $jurnal->pertemuan }}</td>
                <td>{{ $jurnal->studentClass->class_name }} - {{ $jurnal->studentClass->angkatan }}</td>
                <td>{{ $jurnal->pencapaian }}</td>
                <td>
                    <a href="#" class="btn btn-info edit-btn" id="edit-btn-{{ $jurnal->id }}"
                        data-id="{{ $jurnal->id }}" data-toggle="modal" data-target="#detailModal">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>

                    <a href="#" class="btn btn-danger delete-btn" data-id="{{ $jurnal->id }}">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
            @endforeach
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
                <p class="modal-title">Detail Jurnal Pembelajaran</p>
            </div>
            <form action="#" method="post" id="editjurnal">
                {{-- {{ csrf_field() }} --}}
                {{-- {{ method_field('put') }} --}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pertemuan">Pertemuan:</label>
                                <input type="text" class="form-control" id="pertemuan" name="pertemuan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jampel">Jam Pelajaran:</label>
                                <input type="datetime-local" class="form-control" id="jampel" name="jampel">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="materi">Materi:</label>
                        <textarea class="form-control" id="materi" name="materi"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="indikator">Indikator:</label>
                        <textarea class="form-control" id="indikator" name="indikator"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pencapaian">Pencapaian:</label>
                        <textarea class="form-control" id="pencapaian" name="pencapaian"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kehadiran">Kehadiran:</label>
                        <input type="text" class="form-control" id="kehadiran" name="kehadiran">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="update_data" class="btn btn-default pull-left">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
    var idjurnal;
    var table;

    $(function () {
        table = $('.data-table').DataTable({
            processing: true,
            // serverSide: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
        });
    });
</script>
<script>
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        var id = $(this).data('id');

        swal({
            title: "Menghapus Jurnal Pembelajaran",
            text: 'Jurnal yang telah di hapus tidak dapat dikembalikan',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('delete-jurnal') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            swal("Jurnal berhasil dihapus.", {
                                icon: "success",
                            });
                            location.reload();
                        } else if (response.error) {
                            swal(response.error, {
                                icon: "error",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        swal('Terjadi kesalahan saat menghapus jurnal.', {
                            icon: "error",
                        });
                    }
                });
            }
        });
    });
</script>
<script>
$(document).ready(function(){
    var jurnalId; // Define jurnalId variable
    $('.edit-btn').click(function(event){
        event.preventDefault();
        jurnalId = $(this).data('id'); // Assign value to jurnalId variable
        $.ajax({
            url: '/jurnal/getDetail/' + jurnalId,
            type: 'POST',
            data: {_token: '{{ csrf_token() }}', id: jurnalId},
            dataType: 'json',
            success: function(response){
                console.log(response.data);
                $('#jampel').val(response.data.jampel);
                $('#pertemuan').val(response.data.pertemuan);
                $('#materi').val(response.data.materi);
                $('#indikator').val(response.data.indikator);
                $('#pencapaian').val(response.data.pencapaian);
                $('#kehadiran').val(response.data.kehadiran);
                $('#detailModal').modal('show');
            },
            error: function(xhr, status, error){
                console.log(error);
            }
        });
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
            url: base_url + '/jurnal/update/'+ jurnalId,
            data:{
                    idjurnal:jurnalId, // Change variable name to jurnalId
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
                window.location.reload();
            },
            error: function(error) {
                swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
            }
            });
        })
});


</script>


@endpush
