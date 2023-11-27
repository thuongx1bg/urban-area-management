<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Models\User;
use App\Repositories\Building\BuildingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SendNotification extends Controller
{
    public $buildingRepo;
    public function __construct(BuildingRepositoryInterface $buildingRepo)
    {
        $this->middleware('auth');
        $this->buildingRepo = $buildingRepo;
    }

    public function index()
    {
        $user =Auth::user();


        return view('be.admin.notifications.index',compact('user','buildings','qrId'));
    }

    public function detail($id)
    {
        $nofication = json_decode( \App\Models\Notification::find($id)->data);
        $user = User::find($nofication->user_id);
        $qrId = QrCode::where('name',$user->name)->where('note',$user->building->name)->first()->id ?? 0;
        return view('be.admin.notifications.detail',compact('user','qrId'));

    }
}
