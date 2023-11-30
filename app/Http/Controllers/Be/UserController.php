<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Jobs\SendEmail;
use App\Models\Notification;
use App\Models\QrCode;
use App\Models\User;
use App\Notifications\TestNotification;
use App\Repositories\Building\BuildingRepositoryInterface;
use App\Repositories\QrCode\QrCodeRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Crypto\Rsa\KeyPair;

use Yajra\DataTables\DataTables;
use Pusher\Pusher;
class UserController extends Controller
{

    public $userRepo;
    public $buildingRepo;

    public $qrCodeRepo;
    public $roleRepo;
    public function __construct(UserRepositoryInterface $userRepo, BuildingRepositoryInterface $buildingRepo, RoleRepositoryInterface $roleRepo, QrCodeRepositoryInterface $qrCodeRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->buildingRepo = $buildingRepo;
        $this->roleRepo = $roleRepo;
        $this->qrCodeRepo = $qrCodeRepo;

    }


    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            // chủ nhà thấy được những user trong cùng building còn thành viên chỉ thấy mình
            if ($user->roles[0]->id == 2  ){
                if($user->own_id == 0){
                    $data = User::where('building_id',$user->building_id)->get();
                }
                else{
                    $data = User::where('id',$user->id)->get();
                }
            }else{
                $data = $this->userRepo->getAll();
            }

            return  $this->getUser($data,$user);

        }
        return view('be.admin.users.index');
    }

    public function userBuilding(Request $request, $building_id)
    {
        if ($request->ajax()) {

            $data = User::where('building_id',$building_id)->get();

            $user = Auth::user();
            return  $this->getUser($data,$user);

        }
        $building = $this->buildingRepo->find($building_id);
        return view('be.admin.users.indexBuilding',compact('building'));
    }
    public function getUser($data,$user=null)
    {
        return DataTables::of($data)

            ->addIndexColumn()
            ->addColumn('building',function ($row){
                return $row->building->name;
            })
            ->addColumn('status',function ($row){
                if($row->status == 1){
                    return '<div class="btn btn-success btn-icon-split btn-lg " style="padding: 0px 7px">Accepted</div>';
                }elseif ($row->status == -1){
                    return '<div class="btn btn-danger btn-icon-split btn-lg " style="padding: 0px 7px">Rejected</div>';
                }
                return '<div class="btn btn-warning btn-icon-split btn-lg " style="padding: 0px 7px">Pending</div>';

            })
            ->addColumn('role',function ($row){
                if ($row->roles[0]->id == 2){
                    if($row->own_id == 0){
                        return 'House owner';
                    }elseif ($row->own_id == 1){
                        return 'House member';
                    }
                }else{
                    return $row->roles[0]->name;
                }
            })

            ->addColumn('action', function($row) use ($user){
                if ($row->id != 1 && ($row->id != $user->id)) // check admin và chủ tài khoản thì không được xóa
                {
                    $action =  '<a href="'. route('user.edit',['id'=>$row->id]) .'" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                            <a href="' . route('user.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                }else{
                    $action = '<a href="'. route('user.edit',['id'=>$row->id]) .'" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>';
                }
                return $action;
            })

            ->rawColumns(['action','building','status','role'])

            ->make(true);
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $checkOwn = false;
        if(Auth::user()->roles[0]->id == 2 ){
            $checkOwn = true;
        }
        $user = $this->userRepo->find($id);
        $buildings = $this->buildingRepo->getAll();
        $roles = $this->roleRepo->getAll();
        $roleOfUser=$user->roles;

        return view('be.admin.users.edit',compact('user','buildings','roles','roleOfUser','checkOwn'));

    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try{

            DB::beginTransaction();
            if ($request->reset_password == 1){
                $request->merge(["password"=> Hash::make("123456789")]);
            }
            $oldUser = $this->userRepo->find($id);

            $user = $this->userRepo->update($id, $request->all());

            if ($oldUser->name != $request->name || $oldUser->building_id != $request->building_id){

                $idQr = $this->qrCodeRepo->getIdQrCodeOfOwner($id);
                $dataQr = [
                    'name'=>$user->name,
                    'note'=>$user->building->name,
                    'user_id'=>$user->id,
                    'username'=>$user->username,
                    'phone'=>$user->phone,
                    'gender'=>$user->gender,
                    'date'=>null,
                    'own_id'=> 0
                ];

                $this->qrCodeRepo->createOrUpdateQrCode($dataQr,$idQr);
            }

            DB::commit();
            return redirect()->route('user.index')->with('success', config('messages.success'));
        }catch(Exception $exception){
            DB::rollBack();
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('user.index')->with('error', config('messages.error'));
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $buildings = $this->buildingRepo->getAll();
        // chủ nhà thì chỉ tọa thành viên trong nhà được
        $checkOwn = false;
        if(Auth::user()->roles[0]->id == 2 ){
            $checkOwn = true;
        }
        $roles = $this->roleRepo->getAll();
        return view('be.admin.users.create',compact('buildings','roles','checkOwn'));
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        try{
            DB::beginTransaction();


            [$privateKey, $publicKey] = createKey($request->username);

            $request->merge(['password'=>Hash::make("123456789"),'public_key'=>$publicKey,'private_key'=>$privateKey]);

            $userCreate = Auth::user();


            if($userCreate->own_id == 0 && $userCreate->roles[0]->id == 2){
                $request->merge(['own_id' => 1]);
            }
            $user = $this->userRepo->create($request->all());


            // send nofication

            sendNotification($user, $userCreate);
            //end send notification

            $dataQr = [
                'name'=>$user->name,
                'note'=>$user->building->name,
                'user_id'=>$user->id,
                'username'=>$user->username,
                'phone'=>$user->phone,
                'gender'=>$user->gender,
                'date'=>null,
                'own_id'=> 0
            ];
            $this->qrCodeRepo->createOrUpdateQrCode($dataQr);

            DB::commit();
            return redirect()->route('user.index')->with('success', config('messages.success'));
        }catch(Exception $exception){
            DB::rollBack();
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('user.index')->with('error', config('messages.error'));
        }
    }





    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $user = $this->userRepo->find($id);
        $username = $user->username;
//        unlink(storage_path('keys/'.$username.'/private.txt'));
//        unlink(storage_path('keys/'.$username.'/public.txt'));
        foreach ($user->qrcodes as $qrCode) {
            $qrCode->delete();
        }
        return $this->userRepo->deleteAndShowConfirm($id);
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function profile($id)
    {
        $user = $this->userRepo->find($id);
        $qrId = QrCode::where('name',$user->name)->where('note',$user->building->name)->first()->id ?? 0;
        $buildings = $this->buildingRepo->getAll();

        return view('be.admin.users.profile',compact('user','buildings','qrId'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function changePassword($id)
    {
        return view('be.admin.users.change_password',compact('id'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function updatePassword(Request $request, $id)
    {
        try{
            $user = $this->userRepo->find($id);
            $validatedData = $request->validate([
                'old_password' => 'required|min:6',
                'password' => 'min:6|required_with:password_confirm|same:password_confirm',
                'password_confirm' => 'min:6',
                // Other validation rules...
            ]);
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'The specified password does not match the database password');
            }
            $user->update(['password'=> Hash::make($request->password)]);
            return redirect()->route('user.index')->with('success', config('messages.success'));
        }catch(Exception $exception){
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('user.index')->with('error', config('messages.error'));
        }
    }


    public function accept($id,$status)
    {
        try {
            $user = User::find($id);
            $update = $user->update(['status'=> $status]);
            $ownHouser = $user::query()->getOwnOfHouse($user->building_id);
            $message = [
                'type' => 'Change status',
                'content' => $status == 1 ? "Accepted":"Pending",
            ];
            SendEmail::dispatch($message, $ownHouser)->delay(now()->addMinute(1));
            sendNotification($user,Auth::user(),'Admin change status account');
            return redirect()->back()->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->back()->with('error', config('messages.error'));
        }
    }


//    public function registerMobile(Request $request)
//    {
//
//        try{
//
//            [$privateKey, $publicKey] = $this->createKey($request->username);
//
//            $request->merge(['password'=>Hash::make($request->password),'public_key'=>$publicKey,'private_key'=>$privateKey]);
//
//            $user = $this->userRepo->create($request->all());
//            $token = $user->createToken($request->username)->plainTextToken;
//
//            $dataQr = [
//                'name'=>$user->name,
//                'note'=>$user->building->name,
//                'user_id'=>$user->id,
//                'username'=>$user->username,
//                'own_id'=> 0
//            ];
//            $this->qrCodeRepo->createOrUpdateQrCode($dataQr);
//            $rs =  ['status'=>true,'token' => $token, 'user'=>$user];
//
//        }catch(\Exception $exception) {
//            $rs =  ['status'=>false];
//
//            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
//        }
//        return response()->json($rs);
//    }


//    public function loginMoblie(Request $request)
//    {
//        $user = User::where('username',$request->username)->first();
//        if(Hash::check($request->password,$user->password)){
//            $token = $user->createToken($request->username)->plainTextToken;
//            $rs = ['status'=>true,'token' => $token, 'user'=>$user];
//        }else{
//            $rs = ['status'=>false,'messages' => "Incorrect Password"];
//        }
//        return $rs;
//    }
}
