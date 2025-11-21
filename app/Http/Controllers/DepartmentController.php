<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;


class DepartmentController extends Controller
{
    // protected $userid = Auth::user()->id;
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
        $data = Department::get();
        $data = DB::table('department')
            ->join('users', 'department.created_id', '=', 'users.id')
            ->select(
                'department.id as id',
                'department.name as name',
                'department.code as code',
                'users.name as created_name',
                'department.created_at as date'
            )
            ->get();

        return view('mstr_department.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $user = auth()->user(); // Ambil user yang sedang login

        return view('mstr_department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $logid = IdGenerator::generate([
            'table' => 'log_activities',
            'field' => 'log_id',
            'length' => 11,
            'prefix' => 'log-'
        ]);


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
                ->withErrors($validator) // Menyimpan error validasi
                ->with('error', 'Error created Data...'); // Menyimpan pesan error umum
        }

        try {
            DB::beginTransaction();

            $data['name'] = $request->name;
            $data['code'] = $request->kode;
            $data['created_id'] = $this->userid;
            //Menambahkan master data 
            $caption = config('custom.cap_create_master');
            $data1 = $data['name'];
            $data2 = 'Department : '; //Sesuain Controller
            $detail = $caption . $data2 . $data1;

            Department::create($data);

            $this->logActivity($logid, $this->userid, 'Master Department', 'Created', $request->name, 'Department ditambahkan');

            DB::commit();
            return redirect()->route('mst_dept.index')->with('success', 'Data created successfully...');
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

        $data = Department::find($decryptID);

        return view('mstr_department.edit', compact('data'));
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
            $data['code'] = $request->kode;

            $caption = config('custom.cap_update_master');
            $data1 = $data['name']; //Sesuain Key
            $data2 = 'Department : '; //Sesuain Controller
            $detail = $caption . $data2 . $data1;

            Department::whereId($id)->update($data);

            $this->logActivity($idlog, $this->userid, 'Master Department', 'Updated', $id, 'Department diperbaharui');

            DB::commit();
            return redirect()->route('mst_dept.index')->with('success', 'Data updated successfully...');
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

        try {
            DB::beginTransaction();
            $data = Department::find($id);

            // dd($detail);
            if ($data) {
                $data->delete();
            }


            $this->logActivity($idlog, $this->userid, 'Master Department', 'Deleted', $id, 'Department dihapus');

            DB::commit();
            return redirect()->route('mst_dept.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
