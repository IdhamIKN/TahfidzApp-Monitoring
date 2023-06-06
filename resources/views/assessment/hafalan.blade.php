<?php
    use Yajra\Datatables\Datatables;
    use App\Model\User\User;

    // get user auth
    $user = Auth::user();
?>
@extends('master')

@section('title', '')

@section('content')

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
@if(Auth::user()->account_type != User::ACCOUNT_TYPE_PARENT)
@endif
<hr>
<div class="table-responsive">
    <table class="table table-bordered data-table display nowrap " style="width:100%">
        <thead>
            <tr>
                <th width="20%">Tanggal </th>
                <th width="30%">Nama</th>
                <th width="20%">Kehadiran</th>
                <th width="50%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absen as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ $data_siswa->siswa_name }}</td>
                <td>{{ $Attendance->where('id', $item->attendance)->pluck('name')->first() }}</td>
                <td>{{ $item->ket }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
    var total_page;
    var table;
    var id_siswa = '{{ $data_siswa->id }}';

    // $(function () {

    //     var url = '{{ route("create-assessment", ":id") }}';
    //     url = url.replace(':id', id_siswa);

    //     table = $('.data-table').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         bFilter: false,
    //         bInfo: false,
    //         rowReorder: {
    //             selector: 'td:nth-child(2)'
    //         },
    //         responsive: true,
    //         "aaSorting": [[ 3, "desc" ]],
    //         ajax: url,
    //         columns: [
    //             {data: 'assessment', name: 'assessment'},
    //             {data: 'range', name: 'range'},
    //             {data: 'note', name: 'note'},
    //             {data: 'date', name: 'date'},
    //         ]
    //     });
    // });

    // $(document).ready(function() {

    //     $( "#iqro_id" ).change(function() {

    //             iqro_id = $(this).val();

    //             $.ajax({
    //             type:'GET',
    //             url: base_url + '/assessment/get-total-page',
    //             data:{
    //                 iqro_id:iqro_id,
    //                 "_token": "{{ csrf_token() }}",
    //             },
    //         success:function(data) {
    //             total_page = data;
    //         },
    //         error: function(error) {
    //             swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
    //             }
    //         });
    //         });
    // })

</script>

@endpush
