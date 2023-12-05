<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\History;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // show history

        $buildings = Building::all();
        // end show history
        if ($request->ajax()) {

            $data = History::orderBy('created_at', 'desc')->get();
            if ($request->filled('from_date') && $request->filled('to_date') && $request->filled('building_id')) {

                $startTime = Carbon::createFromFormat('Y/m/d H:i', $request->from_date);
                $endTime = Carbon::createFromFormat('Y/m/d H:i', $request->to_date);
                $buildingId = $request->building_id;
                $data = History::orderBy('created_at', 'desc')->whereBetween('created_at', [$startTime, $endTime])
                    ->when( ($buildingId != 0 ), function ($q) use ($buildingId) {
                        $users = Building::find($buildingId)->users->pluck('id');
                        $qrId = QrCode::whereIn('user_id',$users)->withTrashed()->pluck('id');
                        return $q->whereIn('qr_id',$qrId);
                    })
                    ->withTrashed()->get();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('house', function ($row) {
                    return $row->qrcode->user->building->name;
                })
                ->addColumn('name', function ($row) {
                    return $row->qrcode->name;
                })
                ->addColumn('note', function ($row) {
                    return $row->qrcode->note;
                })
                ->addColumn('rule', function ($row) {
                    return $row->qrcode->own_id == 0 ? ($row->qrcode->user->own_id == 0 ? "House Own" : "House member") : "Guest";
                })
                ->rawColumns(['date','house','rule','name','note'])
                ->make(true);

        }

        return view('be.admin.history.index',compact('buildings'));
    }
}
