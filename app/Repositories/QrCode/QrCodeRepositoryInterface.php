<?php

namespace App\Repositories\QrCode;

use App\Repositories\RepositoryInterface;

interface QrCodeRepositoryInterface extends RepositoryInterface
{

//    public function createQrCode($note, $name, $user);
    public function createOrUpdateQrCode($dataQr, $id);
    public function getIdQrCodeOfOwner($userId);

}
