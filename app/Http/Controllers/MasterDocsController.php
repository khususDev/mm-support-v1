<?php

namespace App\Http\Controllers;

use App\Models\MasterDocs;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;


class MasterDocsController extends Controller
{
    protected $userid;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::check() ? Auth::user()->id : null;
            return $next($request);
        });
    }
    public function index()
    {
        $data = DB::table('master_docs')
            ->join('users', 'master_docs.created_id', '=', 'users.id')
            ->select(
                'master_docs.id as id',
                'master_docs.name as name',
                'master_docs.kode as code',
                'users.name as created_name',
                'master_docs.created_at as date'
            )
            ->get();

        return view('mstr_type_document.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mstr_type_document.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $logid = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'kode' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput() // Menyimpan input agar form terisi dengan data sebelumnya
                ->withErrors($validator)
                ->with('error', 'Error created Data...');
        }

        try {
            DB::beginTransaction();

            $data['name'] = $request->name;
            $data['kode'] = $request->kode;
            $data['created_id'] = $this->userid;

            MasterDocs::create($data);

            $this->logActivity($logid, $this->userid, 'Master Document', 'Created', $request->name, 'Master Document dihapus');

            DB::commit();
            return redirect()->route('mst_docs.index')->with('success', 'Data created successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == 23000 || $e->getCode() == 1062) {
                return redirect()->back()->withInput()->with('error', 'Data sudah terdaftar, Gunakan Data Lain!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $decryptID = Crypt::decryptString($id);

        $data = MasterDocs::find($decryptID);

        return view('mstr_type_document.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'kode' => 'required',
            ]
        );

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator)->with('error', 'Error updated Data...');
        try {
            DB::beginTransaction();

            $data['name'] = $request->name;
            $data['kode'] = $request->kode;

            MasterDocs::whereId($id)->update($data);

            $this->logActivity($idlog, $this->userid, 'Master Document', 'Updated', $id, 'Master Document diperbaharui');

            DB::commit();
            return redirect()->route('mst_docs.index')->with('success', 'Data updated successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);
        // dd($idlog);
        try {
            DB::beginTransaction();
            $data = MasterDocs::find($id);

            if ($data) {
                $data->delete();
            }

            $this->logActivity($idlog, $this->userid, 'Master Document', 'Deleted', $id, 'Master Document dihapus');

            DB::commit();
            return redirect()->route('mst_docs.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
