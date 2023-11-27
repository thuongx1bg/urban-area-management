<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequest;
use App\Repositories\Building\BuildingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class BuildingController extends Controller
{
    public $buildingRepo;

    public function __construct(BuildingRepositoryInterface $buildingRepo)
    {
        $this->middleware('auth');
        $this->buildingRepo = $buildingRepo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->buildingRepo->getAll();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('building.edit', ['id' => $row->id]) . '" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                            <a href="' . route('building.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                })
                ->addColumn('link', function ($row) {
                    return '<a target="__blank" href="' . route('user.building.index',['building_id'=> $row->id]) . '" class="btn btn-warning btn-icon-split btn-lg " style="padding: 0px 7px">Link</a>';
                })
                ->rawColumns(['action','link'])
                ->make(true);

        }


        return view('be.admin.buildings.index');
    }

    public function create()
    {
        return view('be.admin.buildings.create');
    }

    public function store(BuildingRequest $request)
    {

        try {
            $this->buildingRepo->create($request->all());
            return redirect()->route('building.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('building.index')->with('error', config('messages.error'));
        }

    }

    public function edit($id)
    {
        $building = $this->buildingRepo->find($id);

        return view('be.admin.buildings.edit', compact('building'));

    }

    public function update(BuildingRequest $request, $id)
    {
        try {
            $this->buildingRepo->update($id, $request->all());
            return redirect()->route('building.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('building.index')->with('error', config('messages.error'));
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
        return $this->buildingRepo->deleteAndShowConfirm($id);
    }


    public function apiListBuilding()
    {
        $data = $this->buildingRepo->getAll();
        return response()->json($data);
    }
}
