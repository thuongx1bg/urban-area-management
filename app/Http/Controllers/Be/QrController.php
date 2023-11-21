<?php

namespace App\Http\Controllers\Be;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Repositories\QrCode\QrCodeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;
use Yajra\DataTables\DataTables;

class QrController extends Controller
{

    public $qrRepo;
    public $userRepo;

    public function __construct(QrCodeRepositoryInterface $qrRepo, UserRepositoryInterface $userRepo)
    {
        $this->qrRepo = $qrRepo;
        $this->userRepo = $userRepo;

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->qrRepo->getAll();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('link', function ($row) {
                    return '<a target="__blank" href="' . route('qr.infor', ['qr_id' => $row->id]) . '" class="btn btn-warning btn-icon-split btn-lg " style="padding: 0px 7px">Link</a>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('qr.edit', ['id' => $row->id]) . '" class="edit btn btn-info btn-circle"><i class="fas fa-info-circle"></i></a>
                            <a href="' . route('qr.delete', ['id' => $row->id]) . '" class="action_delete delete btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>';
                })
                ->rawColumns(['action', 'link'])
                ->make(true);

        }


        return view('be.admin.qrs.index');
    }


    public function check(Request $request)
    {

        $qr = $this->qrRepo->find($request->qrId);

        $username = $this->userRepo->find($qr->user_id)->username;

        $publicKey = PublicKey::fromFile(storage_path('keys/' . $username . '/public.txt'));

        $si = ('name:' . $request->name . ';note:' . $request->note);

        $check = false;
        if ($publicKey->verify($si, $qr->ds)) {
            $check = true;
        };

        dd($check);

        return view('be.admin.qrs.result', compact('check'));

    }

    public function create()
    {
        return view('be.admin.qrs.create');
    }

    public function checkForm()
    {
        return view('be.admin.qrs.check');

    }

    public function store(Request $request)
    {
        try {

            $note = $request->note;
            $name = $request->name;
            $user = Auth::user();
            $dataQr = [
                'name' => $name,
                'note' => $note,
                'user_id' => $user->id,
                'username' => $user->username,
                'own_id' => 1
            ];
            $this->qrRepo->createOrUpdateQrCode($dataQr);

            return redirect()->route('qr.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('qr.index')->with('error', config('messages.error'));
        }

    }

    public function edit($id)
    {
        $qr = $this->qrRepo->find($id);

        return view('be.admin.qrs.edit', compact('qr'));
    }

    public function infor($id)
    {
        $qr = $this->qrRepo->find($id);

        $user = $this->userRepo->find($qr->user_id);
        return view('be.admin.qrs.infor', compact('qr', 'user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $note = $request->note;
            $name = $request->name;
            $user = $this->userRepo->find($this->qrRepo->find($id)->user_id);
            $dataQr = [
                'name' => $name,
                'note' => $note,
                'user_id' => $user->id,
                'username' => $user->username,
                'own_id' => 1
            ];
            $this->qrRepo->createOrUpdateQrCode($dataQr, $id);

            return redirect()->route('qr.index')->with('success', config('messages.success'));
        } catch (Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . 'Line' . $exception->getLine());
            return redirect()->route('qr.index')->with('error', config('messages.error'));
        }
    }

    public function delete($id)
    {
        return $this->qrRepo->deleteAndShowConfirm($id);
    }
}
