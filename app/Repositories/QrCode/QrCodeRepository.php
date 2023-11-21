<?php


namespace App\Repositories\QrCode;

use App\Models\QrCode;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;
use Spatie\Crypto\Rsa\PrivateKey;

class QrCodeRepository extends BaseRepository implements QrcodeRepositoryInterface
{

    public function getModel()
    {
        return QrCode::class;
    }

    public function createOrUpdateQrCode($dataQr, $id=null)
    {
        try {

            $pathToPrivateKey = storage_path('keys/' . $dataQr['username'] . '/private.txt');
            $si = ('name:' . $dataQr['name'] . ';note:' . $dataQr['note']);
            // chu ky so
            $ds = PrivateKey::fromFile($pathToPrivateKey)->sign($si);

            if($id){
                $qr = $this->update($id,[
                    'note'=>$dataQr['note'],
                    'name' => $dataQr['name'],
                    'ds' => $ds,
                    'user_id' => $dataQr['user_id'],
                    'si' =>$si,
                    'own_id'=> $dataQr['own_id'],
                ]);
            }else{
                $qr = $this->create([
                    'note' => $dataQr['note'],
                    'name' => $dataQr['name'],
                    'ds' => $ds,
                    'user_id' => $dataQr['user_id'],
                    'si' => $si,
                    'own_id'=> $dataQr['own_id']
                ]);
            }
            return $qr;


        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
        }
    }

    public function getIdQrCodeOfOwner($userId)
    {
        return $this->model->where('user_id',$userId)->where('own_id',0)->first()->id;
    }


}
