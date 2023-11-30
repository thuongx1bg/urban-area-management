<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Repositories\QrCode\QrCodeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
class UserSeeder extends Seeder
{
    public $userRepo;
    public $qrCodeRepo;
    public function __construct(UserRepositoryInterface $userRepo, QrCodeRepositoryInterface $qrCodeRepo)
    {
         $this->userRepo =$userRepo ;
         $this->qrCodeRepo = $qrCodeRepo;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $buildings = Building::where('address','!=', 'Management')->get();
        foreach ($buildings as $building){
            for($i=1; $i<3;$i++){
                [$privateKey, $publicKey] = createKey($i==1 ? 'thuongx1bgown'.$building->id : 'thuongx1bg'.$i.$building->id);
                $data =
                    [   'name'=> $faker->name,
                        'username'=> $i==1 ? 'thuongx1bgown'.$building->id : 'thuongx1bg'.$i.$building->id,
                        'email'=> $i == 1 ? 'thuongx1bgown'.$building->id .'@gmail.com': 'thuongx1bg'.$i.$building->id.'@gmail.com',
                        'building_id' => $building->id,
                        'phone'=> "0387589077",
                        'password' => Hash::make('123456789'),
                        'status' => 1,
                        'cmt' => $faker->unique()->numerify('##########'),
                        'gender' => random_int(0,1),
                        'date' => "2001-08-24",
                        'own_id'=>$i ==1 ? 0 : 1,
                        'image' => $faker->imageUrl($width = 640, $height = 480),
                        'public_key'=>$publicKey,
                        'private_key'=>$privateKey
                    ];
                $user = $this->userRepo->create($data);
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
            }
        }

    }
}
