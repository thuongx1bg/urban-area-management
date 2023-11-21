<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface {

    public function getModel()
    {
        return Role::class;
    }

    public function create($attributes = []){
        try {
            DB::beginTransaction();
            $role = $this->model->create($attributes);
            $role->permissions()->attach($attributes['permission_id']);
            DB::commit();
            return $role;
        } catch(Exception $exception){
            DB::rollBack();
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
        }
    }

    public function update($id, $atrr = [])
    {
        try {
            DB::beginTransaction();
            $role = $this->model->find($id);
            if ($role) {
                $role->update($atrr);
                $role->permissions()->sync($atrr['permission_id']);
                DB::commit();
                return $role;
            }
            return false;
        } catch(Exception $exception){
            DB::rollBack();
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
        }

    }

    public function deleteAndShowConfirm($id)
    {
        try {
            DB::beginTransaction();
            $role = $this->model->find($id)->permissions()->sync([]);
            $this->delete($id);
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'success',

            ], status: 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail',
            ], status: 500);
        }
    }
}
