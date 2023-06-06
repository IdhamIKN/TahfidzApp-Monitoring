<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;

use App\Model\ActionLog\ActionLog;

// model
use App\Model\Jurnal\Jurnal;
use App\Model\User\User;
use App\Http\Resources\Jurnal\JurnalResource;
use App\Http\Requests\Jurnal\StoreJurnalRequest;
use App\Http\Requests\Jurnal\UpdateJurnalRequest;
use App\Model\Siswa\Siswa;
use App\Model\StudentClass\StudentClass;


// use Auth;
use Illuminate\Support\Facades\Auth;

// use DB;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Model\Helper\Permission;

use Illuminate\Http\Request;

class JurnalController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $data = Jurnal::where('id_guru', $user->id)
                ->orderBy('created_at', 'DESC')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jampel', function (Jurnal $value) {
                    $date =  Carbon::parse($value->date);
                    return $date->format('H:i d-m-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button onclick="btnUbah(' . $row->id . ')" name="btnUbah" type="button" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></button>';
                    $delete = '<button onclick="btnDel(' . $row->id . ')" name="btnDel" type="button" class="btn btn-info"><span class="glyphicon glyphicon-trash"></span></button>';
                    return $btn . '&nbsp' . '&nbsp' . $delete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $this->systemLog(false, 'Mengakses Halaman Jurnal');
        return view('jurnal.index', ['active' => 'Jurnal']);
    }

    public function jurnal(Request $request)
    {
        $user = Auth::user();
        // Check user account type
        if ($user->account_type == User::ACCOUNT_TYPE_ADMIN || $user->account_type == User::ACCOUNT_TYPE_CREATOR) {
            // Display all journal data
            $data = Jurnal::orderBy('created_at', 'DESC')->get();
        } else if ($user->account_type == User::ACCOUNT_TYPE_TEACHER) {
            // Display journal data from logged-in teacher only
            $data = Jurnal::where('id_guru', $user->id)
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        // Kirim variabel $user dan $data ke view
        return view('jurnal.saya', ['active' => 'Jurnal-saya'], ['user' => $user, 'data' => $data]);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $jurnal = Jurnal::findOrFail($request->get('idjurnal'));
            return new JurnalResource($jurnal);
        }
    }

    public function store(StoreJurnalRequest $request)
    {
        DB::beginTransaction();

        $jurnal = new Jurnal();

        $jurnal->id_guru    = auth()->user()->id; // mengambil id guru dari user yang sedang login
        $jurnal->jampel     = Carbon::parse($request->get('jampel')); // mengubah input jampel menjadi Carbon instance
        $jurnal->pertemuan  = $request->get('pertemuan');
        $jurnal->materi     = $request->get('materi');
        $jurnal->indikator  = $request->get('indikator');
        $jurnal->pencapaian = $request->get('pencapaian');
        $jurnal->kehadiran  = $request->get('kehadiran');
        $jurnal->class      = $request->get('class');

        if (!$jurnal->save()) {
            DB::rollBack();
            $this->systemLog(true, 'Gagal Menyimpan Jurnal');
            return redirect('jurnal')->with('alert_error', 'Gagal Disimpan');
        }

        if ($this->getUserPermission('create jurnal')) {
            DB::commit();
            $this->systemLog(false, 'Berhasil Menyimpan Input Jurnal');
            return redirect('jurnal')->with('alert_success', 'Berhasil Disimpan');
        } else {
            DB::rollBack();
            $this->systemLog(true, 'Gagal Menyimpan Input Jurnal');
            return redirect('jurnal')->with('alert_error', 'Gagal Disimpan');
        }
    }

    public function delete(Request $request)
    {
        $jurnal = Jurnal::find($request->id);

        if ($jurnal) {
            $jurnal->delete();
            return response()->json(['success' => 'Jurnal berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Jurnal tidak ditemukan.']);
        }
    }


    public function search(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month');


        // Ambil bulan dan tahun dari nilai input field "month"
        $bulan = date('m', strtotime($month));
        $tahun = date('Y', strtotime($month));

        // Check user account type
        if ($user->account_type == User::ACCOUNT_TYPE_ADMIN || $user->account_type == User::ACCOUNT_TYPE_CREATOR) {
            // Display all journal data in the selected month and year
            $data = Jurnal::whereMonth('jampel', $bulan)
                ->whereYear('jampel', $tahun)
                ->orderBy('jampel', 'DESC')
                ->get();
        } else if ($user->account_type == User::ACCOUNT_TYPE_TEACHER) {
            // Display journal data from logged-in teacher only in the selected month and year
            $data = Jurnal::where('id_guru', $user->id)
                ->whereMonth('jampel', $bulan)
                ->whereYear('jampel', $tahun)
                ->orderBy('jampel', 'DESC')
                ->get();
        }

        $request->session()->put('jurnal_data', $data);
        // Kirim variabel $user dan $data ke view
        return view('jurnal.saya', ['active' => 'Jurnal-saya'], [
            'user' => $user,
            'data' => $data,
            'request' => $request
        ]);
    }

    public function printPdf($id)
    {
        $user = Auth::user();
        $data = Jurnal::where('id', $id)->first();

        $pdf = \PDF::loadView('jurnal.jurnal_detail', [
            'user' => $user,
            'data' => $data,
        ]);

        return $pdf->stream();
    }

    public function printSessionData()
    {
        $user = Auth::user();
        $data = session('jurnal_data');
        $bulan = session('jurnal_bulan');
        $tahun = session('jurnal_tahun');

        $pdf = \PDF::loadView('jurnal.jurnal', [
            'user' => $user,
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun
        ])->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    //

    public function getDetail( $id){
        // Cari data jurnal berdasarkan ID
        $jurnal = Jurnal::findOrFail($id);

        // Mengembalikan data jurnal dalam format JSON
        return response()->json(['data' => $jurnal]);
    }

    public function update(UpdateJurnalRequest $request, $id)
    {
        DB::beginTransaction();

        $jurnal = Jurnal::findOrFail($id);

            $jurnal->jampel     = Carbon::parse($request->get('jampel'));
            $jurnal->pertemuan  = $request->get('pertemuan');
            $jurnal->materi     = $request->get('materi');
            $jurnal->indikator  = $request->get('indikator');
            $jurnal->pencapaian = $request->get('pencapaian');
            $jurnal->kehadiran  = $request->get('kehadiran');
        if(!$jurnal->save())
        {
            $this->systemLog(true,'Gagal Mengupdate Jurnal');
            DB::rollBack();
            return $this->getResponse(false,400,'','Jurnal gagal diupdate');
        }

        if($this->getUserPermission('index class'))
        {
            $this->systemLog(false,'Berhasil Mengupdate Jurnal');
            DB::commit();
            return $this->getResponse(true,200,'','Jurnal berhasil diupdate');
        }
        else
        {
            return $this->getResponse(false,505,'','Tidak mempunyai izin untuk aktifitas ini');
        }
    }

}
