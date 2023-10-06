<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\Building\BuildingRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Crypto\Rsa\KeyPair;

use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public $userRepo;
    public $buildingRepo;


    public function __construct(UserRepositoryInterface $userRepo, BuildingRepositoryInterface $buildingRepo)
    {
        $this->userRepo = $userRepo;
        $this->buildingRepo = $buildingRepo;

    }

    public function index( Request $request)
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

    public function edit($id)
    {
        $user = $this->userRepo->find($id);
        $buildings = $this->buildingRepo->getAll();

        return view('be.admin.users.edit',compact('user','buildings'));

    }

    public function update(Request $request, $id)
    {
        try{
            if ($request->reset_password == 1){
                $request->merge(["password"=> Hash::make("123456789")]);
            }
            $this->userRepo->update($id, $request->all());
            return redirect()->route('user.index')->with('success', "Sửa user thành công");
        }catch(Exception $exception){
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('user.index')->with('error', "Sửa user thất bại");
        }
    }

    public function create()
    {
        $buildings = $this->buildingRepo->getAll();
        return view('be.admin.users.create',compact('buildings'));
    }

    public function store(UserRequest $request)
    {
        try{
            $pathToPrivateKey = ("app/keys/".$request->username."/private.txt") ;
            $pathToPublicKey = ("app/keys/".$request->username."/public.txt") ;

            Storage::disk('local')->put($pathToPrivateKey,"");
            Storage::disk('local')->put($pathToPublicKey,"");

            [$privateKey, $publicKey] = (new KeyPair())->generate(storage_path($pathToPrivateKey), storage_path($pathToPublicKey));


            $request->merge(['password'=>Hash::make("123456789"),'public_key'=>$publicKey,'private_key'=>$privateKey]);
            $this->userRepo->create($request->all());
            return redirect()->route('user.index')->with('success', "Thêm user thành công");
        }catch(Exception $exception){
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('user.index')->with('error', "Thêm user thất bại");
        }
    }

    public function delete($id)
    {
        $username = $this->userRepo->find($id)->username;
        unlink(storage_path('app/keys/'.$username.'/private.txt'));
        unlink(storage_path('app/keys/'.$username.'/public.txt'));
        return $this->userRepo->deleteAndShowConfirm($id);
    }

    public function profile($id)
    {
        $user = $this->userRepo->find($id);
        $buildings = $this->buildingRepo->getAll();

        return view('be.admin.users.profile',compact('user','buildings'));
    }
}
