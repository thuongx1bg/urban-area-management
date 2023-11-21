<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\QrCode;
use App\Models\User;
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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Crypto\Rsa\KeyPair;

use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public $userRepo;
    public $buildingRepo;

    public $qrCodeRepo;
    public $roleRepo;
    public function __construct(UserRepositoryInterface $userRepo, BuildingRepositoryInterface $buildingRepo, RoleRepositoryInterface $roleRepo, QrCodeRepositoryInterface $qrCodeRepo)
    {
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

            $data = $this->userRepo->getAll();

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
                ->addColumn('action', function($row){
                    return '<a href="'. route('user.edit',['id'=>$row->id]) .'" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                            <a href="' . route('user.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                })

                ->rawColumns(['action','building','status'])

                ->make(true);

        }
        return view('be.admin.users.index');
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $user = $this->userRepo->find($id);
        $buildings = $this->buildingRepo->getAll();
        $roles = $this->roleRepo->getAll();
        $roleOfUser=$user->roles;

        return view('be.admin.users.edit',compact('user','buildings','roles','roleOfUser'));

    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try{
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
                    'own_id'=> 0
                ];

                $this->qrCodeRepo->createOrUpdateQrCode($dataQr,$idQr);
            }

            return redirect()->route('user.index')->with('success', config('messages.success'));
        }catch(Exception $exception){
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
        $roles = $this->roleRepo->getAll();
        return view('be.admin.users.create',compact('buildings','roles'));
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        try{

            [$privateKey, $publicKey] = $this->createKey($request->username);

            $request->merge(['password'=>Hash::make("123456789"),'public_key'=>$publicKey,'private_key'=>$privateKey]);

            $user = $this->userRepo->create($request->all());

            $dataQr = [
                'name'=>$user->name,
                'note'=>$user->building->name,
                'user_id'=>$user->id,
                'username'=>$user->username,
                'own_id'=> 0
            ];
            $this->qrCodeRepo->createOrUpdateQrCode($dataQr);

            return redirect()->route('user.index')->with('success', config('messages.success'));
        }catch(Exception $exception){
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('user.index')->with('error', config('messages.error'));
        }
    }

    /**
     * @param $username
     * @return array
     */
    public function createKey($username)
    {
        $pathToPrivateKey = ("keys/".$username) ;
        $pathToPublicKey = ("keys/".$username) ;

        if (!File::exists(storage_path($pathToPrivateKey))) {
            File::makeDirectory(storage_path($pathToPrivateKey), 0775, true);
        }
        if (!File::exists(storage_path($pathToPublicKey))) {
            File::makeDirectory(storage_path($pathToPublicKey), 0775, true);
        }

        [$privateKey, $publicKey] = (new KeyPair())->generate(storage_path($pathToPrivateKey."/private.txt"), storage_path($pathToPublicKey."/public.txt"));

        return [$privateKey, $publicKey];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $username = $this->userRepo->find($id)->username;
        unlink(storage_path('keys/'.$username.'/private.txt'));
        unlink(storage_path('keys/'.$username.'/public.txt'));
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
            $request->merge(["password"=> Hash::make($request->password)]);
            $this->userRepo->update($id, $request->all());
            return redirect()->route('user.index')->with('success', config('messages.success'));
        }catch(Exception $exception){
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('user.index')->with('error', config('messages.error'));
        }
    }


    public function registerMobile(Request $request)
    {

        try{

            [$privateKey, $publicKey] = $this->createKey($request->username);

            $request->merge(['password'=>Hash::make($request->password),'public_key'=>$publicKey,'private_key'=>$privateKey]);

            $user = $this->userRepo->create($request->all());
            $token = $user->createToken($request->username)->plainTextToken;

            $dataQr = [
                'name'=>$user->name,
                'note'=>$user->building->name,
                'user_id'=>$user->id,
                'username'=>$user->username,
                'own_id'=> 0
            ];
            $this->qrCodeRepo->createOrUpdateQrCode($dataQr);
            $rs =  ['status'=>true,'token' => $token, 'user'=>$user];

        }catch(\Exception $exception) {
            $rs =  ['status'=>false];

            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
        }
        return response()->json($rs);
    }


    public function loginMoblie(Request $request)
    {
        $user = User::where('username',$request->username)->first();
        if(Hash::check($request->password,$user->password)){
            $token = $user->createToken($request->username)->plainTextToken;
            $rs = ['status'=>true,'token' => $token, 'user'=>$user];
        }else{
            $rs = ['status'=>false,'messages' => "Incorrect Password"];
        }
        return $rs;
    }
}
