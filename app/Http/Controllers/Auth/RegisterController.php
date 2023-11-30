<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Repositories\Building\BuildingRepositoryInterface;
use App\Repositories\QrCode\QrCodeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Crypto\Rsa\KeyPair;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $buildingRepo;
    protected $userRepo;
    public $qrCodeRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BuildingRepositoryInterface $buildingRepo, UserRepositoryInterface $userRepo, QrCodeRepositoryInterface $qrCodeRepo)
    {
        $this->middleware('guest');
        $this->buildingRepo = $buildingRepo;
        $this->userRepo = $userRepo;
        $this->qrCodeRepo = $qrCodeRepo;


    }
    public function showRegistrationForm()
    {
        $buildings = $this->buildingRepo->getAll();
        return view('auth.register',compact('buildings'));
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data['own_id'] == 0){
            $email = 'unique:users,email';
        }else{
            $email = 'nullable';
        }
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ' string | email | max:255 |'.$email,
            'username' => 'required | string |max:255 | unique:users,username',
            'password' => 'min:6|required_with:password_confirm|same:password_confirm',
            'password_confirm' => 'min:6',
            'cmt' => 'string | max:255 | nullable ',
            'phone' => 'string | max:255 | nullable',
            'date' => 'required|before:today|'

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        [$privateKey, $publicKey] = $this->createKey($data['username']);
        $data = [
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'cmt'=>$data['cmt'],
            'phone'=>$data['phone'],
            'date'=>$data['date'],
            'own_id'=>$data['own_id'],
            'status'=> 0,
            'building_id'=>$data['building_id'],
            'password' => Hash::make($data['password']),
            'public_key'=>$publicKey,
            'private_key'=>$privateKey
        ];
        $user =   $this->userRepo->create( $data);
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
        sendNotification($user, $user);
        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

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
}
