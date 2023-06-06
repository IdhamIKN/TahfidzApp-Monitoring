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

<div class="table-responsive">
    <table class="table table-bordered data-table display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Guru</th>
                <th>Jumlah Santri</th>
                <th>Angkatan</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($studentClasses as $key => $class)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $class->class_name }}</td>
                <td>{{ $class->getTeacher->full_name }}</td>
                <td>{{ $siswa->where('class_id', $class->id)->count() }}</td>
                <td>{{ $class->angkatan }}</td>
                <td> <a href="{{ route('create-absensi', ['id' => $class->id]) }}" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>




@endsection



@push('scripts')
<script type="text/javascript">


</script>

@endpush
