<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface{


    public function create($attributes = []);
    public function update($id, $atrr = []);
    public function deleteAndShowConfirm($id);

}
