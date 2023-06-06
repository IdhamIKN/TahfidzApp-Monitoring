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

<form method="post" action="{{route('jurnal.update')}}">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Pertemuan Ke</label>
                <input type="text" class="form-control" value="{{ $jurnal->pertemuan }}" name="pertemuan">
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
                <input type="datetime-local" class="form-control" value="{{ $jurnal->jampel }}" name="jampel">
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
                    <option value="{{ $jurnal->studentClass->id }}" selected>{{ $jurnal->studentClass->class_name }} -
                        {{ $jurnal->studentClass->angkatan }}</option>
                </select>
                @if ($errors->has('class'))
                <div class="error">
                    <p style="color: red"><span>&#42;</span> {{ $errors->first('class') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Materi</label>
        <textarea class="form-control" placeholder="" rows="3" id="materi"
            name="materi">{{ $jurnal->materi }}</textarea>
    </div>

    <div class="form-group">
        <label>Indikator</label>
        <textarea class=" form-control" placeholder="" rows="3" id="indikator" name="indikator"></textarea>
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
        <button type="submit" class="btn btn-info"> Update </button>
    </div>
</form>

<hr>

@endsection



@push('scripts')

<script type="text/javascript">

</script>
@endpush
