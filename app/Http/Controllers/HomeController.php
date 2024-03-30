<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
    public function index()
    {
        return view('home');
    }
    public function getuser()
    {
        $jk = DB::table('users')->get();

        return response()->json($jk);
    }
    public function getkendaraan()
    {
        $kn = DB::table('kendaraan')->get();
        return response()->json($kn);
    }
    public function getpengemudi()
    {
        $pn = DB::table('driver')->get();
        return response()->json($pn);
    }
    public function addorder(Request $request)
    {
        $order = DB::table('orderkendaraan')->insert([
            'namakendaraan' => $request->namakendaraan,
            'namapengemudi' => $request->namapengemudi,
            'tanggal' => $request->tanggal,
            'cek' => $request->cek,
        ]);
        $hasil = [
            'success' => true,
            'data' => $order,
        ];
        return response()->json($hasil);
    }
    public function getorderprocces()
    {
        $ord = DB::table('orderkendaraan')->whereNull('cek')->get();
        return response()->json($ord);
    }
    public function getorderapproved()
    {
        $ord = DB::table('orderkendaraan')->whereNotNull('cek')->get();
        return response()->json($ord);
    }
    public function changestatus(Request $request, $id)
    {
        $qw = DB::table('orderkendaraan')->where('id', $id)
            ->update([
                'cek' => "Approved",
            ]);
        return response()->json($qw);
    }
    public function changestatuswaiting(Request $request, $id)
    {
        $qw = DB::table('orderkendaraan')->where('id', $id)
            ->update([
                'cek' => null,
            ]);
        return response()->json($qw);
    }
    public function ordersByMonth()
    {
        $count1 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '1')
            ->count();
        $count2 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '2')
            ->count();
        $count3 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '3')
            ->count();
        $count4 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '4')
            ->count();
        $count5 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '5')
            ->count();
        $count6 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '6')
            ->count();
        $count7 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '7')
            ->count();
        $count8 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '8')
            ->count();
        $count9 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '9')
            ->count();
        $count10 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '10')
            ->count();
        $count11 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '11')
            ->count();
        $count12 = DB::table('orderkendaraan')
            ->whereNotNull('cek')
            ->whereYear('tanggal', '2024')
            ->whereMonth('tanggal', '12')
            ->count();
        $hasil = [
            $count1,
            $count2,
            $count3,
            $count4,
            $count5,
            $count6,
            $count7,
            $count8,
            $count9,
            $count10,
            $count11,
            $count12,
        ];
        return response()->json($hasil);
    }
}
