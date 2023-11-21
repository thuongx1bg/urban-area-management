<?php
namespace App\Repositories\Role;

use App\Repositories\RepositoryInterface;

interface RoleRepositoryInterface extends RepositoryInterface{

    public function create($attributes = []);
    public function update($id, $atrr = []);
    public function deleteAndShowConfirm($id);

}
