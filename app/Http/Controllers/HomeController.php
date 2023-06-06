<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Siswa\Siswa;
use App\Model\User\User;
use App\Model\SiswaHasParent\SiswaHasParent;
//

use App\Model\StudentClass\StudentClass;
use App\Model\AssessmentLog\AssessmentLog;

use App\Model\User\UserLoginHistory;

use Carbon\Carbon;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     if ($this->getUserPermission('index home')) {
    //         if ($this->getUserLogin()->account_type == User::ACCOUNT_TYPE_TEACHER || $this->getUserLogin()->account_type == User::ACCOUNT_TYPE_PARENT) {
    //             $siswa = Siswa::where('teacher_id', $this->getUserLogin()->id)->join('tbl_class', 'tbl_siswa.class_id', '=', 'tbl_class.id')->count();
    //             $class = StudentClass::where('teacher_id', $this->getUserLogin()->id)->count();
    //         } else {
    //             $siswa = Siswa::count();
    //             $class = StudentClass::count();
    //         }

    //         $hafalan    = AssessmentLog::where('date', date("Y-m-d"))->count();
    //         $last_login = UserLoginHistory::findLastlogin();

    //         if ($last_login != null) {
    //             $last_login = Carbon::parse($last_login->date);
    //             $last_login = $last_login->format('d M Y');
    //         }

    //         $this->systemLog(false, 'Mengakses Halaman Home');

    //         return view('home.index', ['last_login' => $last_login, 'active' => 'home', 'siswa' => $siswa, 'class' => $class, 'hafalan' => $hafalan]);
    //     } else {
    //         $this->systemLog(true, 'Gagal Mengakses Halaman Home');
    //         return view('error.unauthorized', ['active' => 'home']);
    //     }
    // }



    // public function index()
    // {
    //     if ($this->getUserPermission('index home')) {
    //         if ($this->getUserLogin()->account_type == User::ACCOUNT_TYPE_PARENT ) {
    //             $parent_id = $this->getUserLogin()->id;
    //             // $siswa = SiswaHasParent::where('parent_id', $parent_id)->join('tbl_siswa', 'tbl_siswa.id', '=', 'tbl_siswa_has_parent.siswa_id')->join('tbl_class', 'tbl_siswa.class_id', '=', 'tbl_class.id')->count();
    //             $siswa = SiswaHasParent::where('parent_id', $this->getUserLogin()->id)->count();
    //             // $class = StudentClass::where('teacher_id', $parent_id)->count();
    //         } else if ($this->getUserLogin()->account_type == User::ACCOUNT_TYPE_TEACHER ) {
    //             $siswa = Siswa::where('teacher_id', $this->getUserLogin()->id)->join('tbl_class', 'tbl_siswa.class_id', '=', 'tbl_class.id')->count();
    //             $class = StudentClass::where('teacher_id', $this->getUserLogin()->id)->count();
    //         } else {
    //             $siswa = Siswa::count();
    //             $class = StudentClass::count();
    //         }

    //         $hafalan    = AssessmentLog::where('date', date("Y-m-d"))->count();
    //         $last_login = UserLoginHistory::findLastlogin();

    //         if ($last_login != null) {
    //             $last_login = Carbon::parse($last_login->date);
    //             $last_login = $last_login->format('d M Y');
    //         }

    //         $this->systemLog(false, 'Mengakses Halaman Home');

    //         return view('home.index', ['last_login' => $last_login, 'active' => 'home', 'siswa' => $siswa, 'class' => $class, 'hafalan' => $hafalan]);
    //     } else {
    //     $this->systemLog(true, 'Gagal Mengakses Halaman Home');
    //     return view('error.unauthorized', ['active' => 'home']);
    //     }
    // }

    public function index()
{
    if ($this->getUserPermission('index home')) {
        if ($this->getUserLogin()->account_type == User::ACCOUNT_TYPE_TEACHER ) {
            $siswa = Siswa::where('teacher_id', $this->getUserLogin()->id)->join('tbl_class', 'tbl_siswa.class_id', '=', 'tbl_class.id')->count();
            $class = StudentClass::where('teacher_id', $this->getUserLogin()->id)->count();
        } else if ($this->getUserLogin()->account_type == User::ACCOUNT_TYPE_PARENT) {
            $siswa = SiswaHasParent::where('parent_id', $this->getUserLogin()->id)->count();
            $class = null; // set jumlah kelas menjadi null untuk user dengan tipe akun ACCOUNT_TYPE_PARENT
        } else {
            $siswa = Siswa::count();
            $class = StudentClass::count();
        }

        $hafalan    = AssessmentLog::where('date', date("Y-m-d"))->count();
        $last_login = UserLoginHistory::findLastlogin();

        if ($last_login != null) {
            $last_login = Carbon::parse($last_login->date);
            $last_login = $last_login->format('d M Y');
        }

        $this->systemLog(false, 'Mengakses Halaman Home');

        return view('home.index', ['last_login' => $last_login, 'active' => 'home', 'siswa' => $siswa, 'class' => $class, 'hafalan' => $hafalan]);
    } else {
        $this->systemLog(true, 'Gagal Mengakses Halaman Home');
        return view('error.unauthorized', ['active' => 'home']);
    }
}


}
