<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequest;
use App\Models\Permissions;
use App\Repositories\Building\roleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public $roleRepo;
    public $permissionModel;

    public function __construct(\App\Repositories\Role\RoleRepositoryInterface $roleRepo, Permissions $permissionModel)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionModel = $permissionModel;

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->roleRepo->getAll();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    if ($row->id != 1) // check admin
                    {
                        $action = '<a href="' . route('role.edit', ['id' => $row->id]) . '" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                            <a href="' . route('role.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                    }else{
                        $action = '<a href="' . route('role.edit', ['id' => $row->id]) . '" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>';
                    }

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);

        }


        return view('be.admin.roles.index');
    }

    public function create()
    {
        $permisstions = $this->permissionModel->where('parent_id', 0)->get();
        return view('be.admin.roles.create', compact('permisstions'));
    }

    public function store(Request $request)
    {

        try {
            $this->roleRepo->create($request->all());
            return redirect()->route('role.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('role.index')->with('error', config('messages.error'));
        }

    }

    public function edit($id)
    {
        $permisstions = $this->permissionModel->where('parent_id', 0)->get();
        $role = $this->roleRepo->find($id);
        $permisstionCheck = $role->permissions;
        return view('be.admin.roles.edit', compact('role', 'permisstions', 'permisstionCheck'));

    }

    public function update(Request $request, $id)
    {
        try {
            $this->roleRepo->update($id, $request->all());
            return redirect()->route('role.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('role.index')->with('error', config('messages.error'));
        }
    }

    /**
     * delete
     *
     * @param mixed $id
     * @return void
     */
    public function delete($id)
    {
        return $this->roleRepo->deleteAndShowConfirm($id);
    }
}
