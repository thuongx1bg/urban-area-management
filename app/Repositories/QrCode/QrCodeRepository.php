<?php


namespace App\Repositories\QrCode;

use App\Models\QrCode;
use App\Repositories\BaseRepository;

class QrCodeRepository extends BaseRepository implements QrcodeRepositoryInterface
{

    public function getModel()
    {
        return QrCode::class;
    }
}
