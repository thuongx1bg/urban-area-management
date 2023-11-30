<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\History;
use App\Models\QrCode;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        [$totalUser,$totalUserActive,$buildings,$totalHouse,$totalQr] = $this->statistic();
        $datesArray = [];
        $qrCodeCount = [];


        // show history

        $history = History::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // end show history
        return view('be.admin.dashboard',compact('history','datesArray','qrCodeCount','totalUser','totalHouse','totalQr','totalUserActive','buildings'));
    }

    public function filter_by_date(Request $request)
    {
        [$datesArray, $qrCodeCount] = $this->dateChart($request->startDate, $request->endDate);



        // show history

        $history = History::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // end show history
        [$totalUser,$totalUserActive,$buildings,$totalHouse,$totalQr] = $this->statistic();

        return view('be.admin.dashboard',compact('history','datesArray','qrCodeCount','totalUser','totalHouse','totalQr','totalUserActive','buildings'));

    }

    public function statistic()
    {
        $totalUser = User::count();
        $totalUserActive = User::where('status',1)->count();
        $buildings = Building::all();
        $totalHouse = $buildings->count();
        $totalQr = QrCode::count();

        return [$totalUser,$totalUserActive,$buildings,$totalHouse,$totalQr];
    }


    public function  dateChart($startDate = null, $endDate = null)
    {
        $startDate = Carbon::createFromFormat('Y-m-d\TH:i', $startDate);
        $endDate = Carbon::createFromFormat('Y-m-d\TH:i', $endDate);

// Tạo một chu kỳ thời gian từ ngày bắt đầu đến ngày kết thúc
        $period = CarbonPeriod::create($startDate, $endDate);

// Lặp qua chu kỳ và thêm ngày vào mảng
        $datesArray = [];
        $qrCodeCount = [];
        foreach ($period as $date) {
            $qrCodeCount[] = History::whereDate('created_at',$date)->get()->count();
            $datesArray[] = $date->format('m/d');
        }
        return [$datesArray, $qrCodeCount];
    }
}
