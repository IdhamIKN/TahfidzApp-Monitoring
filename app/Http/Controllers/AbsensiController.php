<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Yajra\Datatables\Datatables;

use App\Model\User\User;
use App\Model\StudentClass\StudentClass;
use App\Model\Siswa\Siswa;
use App\model\ClassHasAbsensi\ClassHasAbsensi;
use App\model\SiswaHasAbsensi\SiswaHasAbsensi;
use App\model\Attendance\Attendance;

use App\Model\Helper\Permission;

use App\Http\Requests\StudentClass\StoreStudentClassRequest;
use App\Http\Requests\StudentClass\UpdateStudentClassRequest;

use App\Http\Resources\StudentClass\StudentClassResource;
use App\Http\Resources\StudentClass\StudentClassCollection;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function siswa()
    {
        return $this->hasMany(\App\Model\Siswa\Siswa::class, 'class_id');
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $studentClasses = StudentClass::all();
        $siswa = Siswa::all();

        if ($this->getUserPermission('index class')) {
            return view('absensi.index', [
                'active' => 'absensi',
                'studentClasses' => $studentClasses,
                'siswa' => $siswa,
                'user' => $user
            ]);
        } else {
            return view('error.unauthorized', ['active' => 'absensi']);
        }
    }

    public function create($id)
    {
        $class = StudentClass::find($id);
        $siswa = Siswa::where('class_id', $id)->get();
        $absenSiswa = SiswaHasAbsensi::all();
        $classes = StudentClass::all();
        return view('absensi.store', ['active' => 'absensi'], compact('classes', 'class', 'siswa', 'absenSiswa'));
    }


    public function edit($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $absensi = $siswa->absensi;
        $class = StudentClass::where('id', $siswa->class_id)->first();
        $absen = SiswaHasAbsensi::all();
        return view('absensi.update', ['active' => 'absensi'], compact('absen', 'class', 'siswa', 'absensi', 'siswa_id'));
    }


    // public function store(Request $request)
    // {
    //     $santri = Siswa::find($request->siswa_id);
    //     $class = StudentClass::find($santri->class_id);
    //     $request->validate([
    //         'date' => 'required|date_format:Y-m-d',
    //         'attendance' => 'required',
    //     ]);

    //     $data = [
    //         'siswa_id' => $request->siswa_id,
    //         'class_id' => $request->class_id,
    //         'date' => $request->date,
    //         'keterangan' => $request->ket,
    //         'attendance' => $request->attendance,
    //         'start_date' => $request->attendance == 1 ? now() : null,
    //         'end_date' => $request->attendance == 1 ? now() : null,
    //     ];

    //     $absensi = SiswaHasAbsensi::create($data);

    //     return redirect()->back()->with('success', 'Data absensi berhasil disimpan.');
    // }
    public function store(Request $request)
{
    $santri = Siswa::find($request->siswa_id);
    $class = StudentClass::find($santri->class_id);
    $request->validate([
        'date' => 'required|date_format:Y-m-d',
        'attendance' => 'required',
    ]);

    $data = [
        'siswa_id' => $request->siswa_id,
        'class_id' => $request->class_id,
        'date' => $request->date,
        'ket' => $request->ket,
        'attendance' => $request->attendance,
        'start_date' => $request->attendance == 1 ? now() : null,
        'end_date' => $request->attendance == 1 ? now() : null,
    ];

    $absensi = SiswaHasAbsensi::where('siswa_id', $request->siswa_id)
                ->where('date', $request->date)
                ->first();

    if ($absensi) {
        $absensi->update($data);
    } else {
        SiswaHasAbsensi::create($data);
    }

    return redirect()->back()->with('success', 'Data absensi berhasil disimpan.');
}




    public function searchByDate(Request $request)
    {
        $classes = StudentClass::all();
        $class = StudentClass::find($request->class_id);
        $siswa = Siswa::where('class_id', $request->class_id)->get();
        $absenSiswa = SiswaHasAbsensi::whereYear('created_at', date('Y', strtotime($request->month)))
            ->whereMonth('created_at', date('m', strtotime($request->month)))
            ->get();
        $data = [
            'class' => $class,
            'siswa' => $siswa,
            'absenSiswa' => $absenSiswa,
        ];
        // return view('absensi.store')->with($data);
        return view('absensi.store', ['active' => 'absensi'], compact('classes', 'class', 'siswa', 'absenSiswa'));
    }

    public function checkAbsensi(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $absensis = SiswaHasAbsensi::where('siswa_id', $request->siswa_id)
            ->where('date', $request->date)
            ->get();

        return response()->json([
            'absensis' => $absensis,
        ]);
    }



    /**
     * @return void
     */

    /**
     * @return void
     */
    public function update($id)
    {
        $class = StudentClass::find($id);
        $siswa = Siswa::where('class_id', $id)->get();
        $absen = SiswaHasAbsensi::all();

        return view('absensi.update', ['active' => 'absensi'], compact('class', 'siswa', 'absen'));
    }

    /**
     * @return void
     */
    public function getUserTeacher(Request $request)
    {
        if ($request->ajax()) {

            if ($request->has('search')) {
                $data_guru = User::getTeacher($request->get('search'));
            } else {
                $data_guru = User::getTeacher();
            }

            $arr_data  = array();

            if ($data_guru) {
                $key = 0;

                foreach ($data_guru as $data) {
                    $arr_data[$key]['id'] = $data->id;
                    $arr_data[$key]['text'] = $data->full_name;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {

            DB::beginTransaction();
            $classModel = StudentClass::findOrFail($request->idclass);

            if (!$classModel->delete()) {
                DB::rollBack();
                return $this->getResponse(false, 400, '', 'Kelas gagal dihapus');
            }

            DB::commit();
            return $this->getResponse(true, 200, '', 'Kelas berhasil dihapus');
        }
    }

    // ------------------------------ Aditional Function -------------------


}
