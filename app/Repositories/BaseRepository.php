<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository implements RepositoryInterface
{
    //model muốn được tương tác
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    //lấy model tương ứng
    abstract public function getModel();

    private function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    /**
     * getAll
     *
     * @return void
     */
    public function getAll()
    {
        return $this->model->latest('created_at')->get();
    }

    /**
     * getByAttribute
     *
     * @param  mixed $attr
     * @return void
     */
    public function getByAttribure($attr = [])
    {
        return $this->model->select($attr)->get();
    }

    /**
     * create
     *
     * @param  mixed $atrr
     * @return void
     */
    public function create($atrr = [])
    {
        return $this->model->create($atrr);
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $atrr
     * @return void
     */
    public function update($id, $atrr = [])
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($atrr);
            return $result;
        }
        return false;
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->delete();
            return $result;
        }
        return false;
    }

    /**
     * find
     *
     * @param  mixed $id
     * @return void
     */
    public function find($id)
    {
        $user = $this->model->find($id);
        if(!$user) abort(404);
        return $user;

    }

    public function deleteAndShowConfirm($id)
    {
        try {
            $this->delete($id);
            return response()->json([
                'code' => 200,
                'message' => 'success',

            ], status: 200);
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail',
            ], status: 500);
        }
    }
}
