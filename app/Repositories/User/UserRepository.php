<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\QrCode\QrCodeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

    public function getModel()
    {
        return User::class;
    }

    public function create($attributes = []){
        try {
            DB::beginTransaction();
            $user = $this->model->create($attributes);
            $user->roles()->attach($attributes['role_id']??2);
            DB::commit();
            return $user;
        } catch(Exception $exception){
            DB::rollBack();
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
        }
    }

    public function update($id, $atrr = [])
    {
        try {
            DB::beginTransaction();
            $user = $this->model->find($id);
            if ($user) {
                $user->update($atrr);
                $user->roles()->sync($atrr['role_id']);
                DB::commit();
                return $user;
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
            $user = $this->model->find($id)->roles()->sync([]);
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
