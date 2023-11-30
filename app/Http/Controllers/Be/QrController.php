<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Http\Requests\QrCodeRequest;
use App\Jobs\SendEmail;
use App\Models\Building;
use App\Models\History;
use App\Models\QrCode;
use App\Models\User;
use App\Repositories\QrCode\QrCodeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;
use Yajra\DataTables\DataTables;

class QrController extends Controller
{

    public $qrRepo;
    public $userRepo;

    public function __construct(QrCodeRepositoryInterface $qrRepo, UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');
        $this->qrRepo = $qrRepo;
        $this->userRepo = $userRepo;

    }

//    public function index(Request $request)
//    {
//        if ($request->ajax()) {
//
//            $data = $this->qrRepo->getAll();
//
//            return DataTables::of($data)
//                ->addIndexColumn()
//                ->addColumn('link', function ($row) {
//                    return '<a target="__blank" href="' . route('qr.infor', ['qr_id' => $row->id]) . '" class="btn btn-warning btn-icon-split btn-lg " style="padding: 0px 7px">Link</a>';
//                })
//                ->addColumn('action', function ($row) {
//                    return '<a href="' . route('qr.edit', ['id' => $row->id]) . '" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
//                            <a href="' . route('qr.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
//                })
//                ->rawColumns(['action', 'link'])
//                ->make(true);
//
//        }
//
//
//        return view('be.admin.qrs.index');
//    }
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            $data = $this->qrRepo->getAll();
            // chủ nhà thấy được những qr trong cùng building còn thành viên chỉ thấy qr của mình
            if ($user->roles[0]->id == 2  ){
                if($user->own_id == 0){
                    $userInBuilding = User::where('building_id',$user->building_id)->get()->pluck(['id']);
                    $data = QrCode::whereIn('user_id',$userInBuilding)->get();
                }
                else{
                    $data = QrCode::where('user_id',$user->id)->get();
                }
                return DataTables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function ($row) {
                        $delete = '';
                        if($row->own_id != 0){
                            $delete = '<a href="' . route('qr.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                        }
                        return '<div class="card">
                                <div class="card-img-top" style="
                                    display: flex;
                                    justify-content: center;
                                    padding-top:25px
                                ">
                               '.\SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($row->ds.'thuongid:'.$row->id).'</div>
                                <div class="card-body" style="
                                        text-align: center;
                                    ">
                                    <h5 class="card-title">'.$row->name.'</h5>
                                    <p class="card-text"></p>
                                    <a target="__blank" href="' . route('qr.infor', ['qr_id' => $row->id]) . '" class="btn btn-warning btn-icon-split btn-lg " style="padding: 0px 7px">Link</a>
                                    <a href="' . route('qr.edit', ['id' => $row->id]) . '" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                                    '.$delete.'
                                </div>
                            </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }else{
                return DataTables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function ($row) {
                        $delete = '';
                        if($row->own_id != 0){
                            $delete = '<a href="' . route('qr.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                        }
                        return '
                                    <a href="' . route('qr.edit', ['id' => $row->id]) . '" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                                    '.$delete.'';
                    })
                    ->addColumn('house', function ($row) {

                        $buildingId = $row->user->building_id;
                        $building = Building::find($buildingId);
                        return $building->name;
                    })
                    ->addColumn('date', function ($row) {

                        if(!$row->date){
                            return 'Unlimited';
                        }
                        $givenDate = Carbon::parse($row->date);

                        $formattedDate = $givenDate->format('H:i, d/m/Y');

                        return $formattedDate;
                    })

                    ->addColumn('link', function ($row) {
                        $delete = '';
                        if($row->own_id != 0){
                            $delete = '<a href="' . route('qr.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                        }
                        return '
                                    <a target="__blank" href="' . route('qr.infor', ['qr_id' => $row->id]) . '" class="btn btn-warning btn-icon-split btn-lg " style="padding: 0px 7px">Link</a>
                                   ';
                    })
                    ->rawColumns(['action','link','house','date'])
                    ->make(true);
            }



        }


        return view('be.admin.qrs.index');
    }


    public function check(Request $request)
    {
        try {
            $data = $request->note;
            [$ds,$id] = explode('thuongid:', $data);

            $check = false;

            $qr = $this->qrRepo->find($id);

            if(!$qr){
                goto rs;
            }

            if($qr->own_id != 0) // khách
            {
                $givenDate = Carbon::parse($qr->date);

                $formattedDate = $givenDate->format('H:i, d/m/Y');
                // Comparison
                if ($givenDate->isPast()) {
                    goto rs; // het han
                }
            }
            $user = $this->userRepo->find($qr->user_id);
            $username = $user->username;

            $publicKey = PublicKey::fromFile(storage_path('keys/' . $username . '/public.txt'));

//            $si = str_replace(' ', '', ('name:' . $request->name . ';note:' . $request->note));

            if ($publicKey->verify($qr->si, $ds)) {
                History::create(['qr_id'=>$qr->id]);
                $check = true;
            };
            rs:
            return view('be.admin.qrs.check', compact('check','user','qr'));
        }catch (\Exception $e){
            $check = false;
            return view('be.admin.qrs.check', compact('check'));

        }

//        view('be.admin.qrs.result', compact('check'));
    }

    public function create()
    {
        return view('be.admin.qrs.create');
    }

    public function checkForm()
    {
        return view('be.admin.qrs.check');

    }

    public function store(QrCodeRequest $request)
    {
        try {

            $note = $request->note;
            $name = $request->name;
            $user = Auth::user();
            $dataQr = [
                'name' => $name,
                'note' => $note,
                'user_id' => $user->id,
                'username' => $user->username,
                'own_id' => 1,
                'phone'=> $request->phone,
                'gender'=>$request->gender,
                'date'=>$request->date
            ];
            $this->qrRepo->createOrUpdateQrCode($dataQr);

            return redirect()->route('qr.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('qr.index')->with('error', config('messages.error'));
        }

    }

    public function edit($id)
    {
        $qr = $this->qrRepo->find($id);
        // nếu qr hết hạn thì không sửa được thông tin và qr của chủ cũng không sửa được thông tin

        $checkDate = true;
        if($qr->own_id != 0) // khách
        {
            $givenDate = Carbon::parse($qr->date);

            $formattedDate = $givenDate->format('H:i, d/m/Y');
            // Comparison
            if ($givenDate->isPast()) {
                $checkDate = false;
            }
        }

        $checkEdit = true;
        if ($qr->own_id == 0 || !$checkDate ){
            $checkEdit = false;
        }
        return view('be.admin.qrs.edit', compact('qr','checkEdit'));
    }

    public function infor($id)
    {
        try {
            $qr = $this->qrRepo->find($id);
            if($qr->own_id != 0) // khách
            {
                $givenDate = Carbon::parse($qr->date);

                $formattedDate = $givenDate->format('H:i, d/m/Y');
                $checkDate = 1;//conf han
                // Comparison
                if ($givenDate->isPast()) {
                    $checkDate = 0; // het han
                }
            }else{
                // mỗi lần dân quẹt là sẽ lưu vào history
//                $history =  History::create(['qr_id'=>$id]);
                //
                $checkDate = 100; // cua chu
                $formattedDate = 1;
            }


            $user = $this->userRepo->find($qr->user_id);
            return view('be.admin.qrs.infor', compact('qr', 'user','checkDate','formattedDate'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('qr.index')->with('error', config('messages.error'));
        }
    }

    public function update(QrCodeRequest $request, $id)
    {
        try {
            $note = $request->note;
            $name = $request->name;
            $user = $this->userRepo->find($this->qrRepo->find($id)->user_id);
            $dataQr = [
                'name' => $name,
                'note' => $note,
                'user_id' => $user->id,
                'username' => $user->username,
                'own_id' => 1,
                'phone'=> $request->phone,
                'gender'=>$request->gender,
                'date'=>$request->date
            ];
            $this->qrRepo->createOrUpdateQrCode($dataQr, $id);

            return redirect()->route('qr.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('qr.index')->with('error', config('messages.error'));
        }
    }

    public function delete($id)
    {
        return $this->qrRepo->deleteAndShowConfirm($id);
    }
}
