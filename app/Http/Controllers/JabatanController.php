<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
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
        $data = DB::table('position as jabatan')
            ->join('users', 'jabatan.created_id', '=', 'users.id')
            ->join('department', 'jabatan.department_id', '=', 'department.id')
            ->select(
                'jabatan.id as id',
                'jabatan.name as name',
                'jabatan.code as code',
                'users.name as created_name',
                'department.name as departmen',
                'jabatan.created_at as date'
            )
            ->get();

        // dd($data);

        return view('mstr_jabatan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dept = Department::all();

        return view('mstr_jabatan.create', compact('dept'));
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
                'post_name' => 'required',
                'post_code' => 'required',
                'departmen' => 'required',
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

            $data['name'] = $request->post_name;
            $data['code'] = $request->post_code;
            $data['department_id'] = $request->departmen;
            $data['created_id'] = $this->userid;

            // dd($data);

            $caption = config('custom.cap_create_master');
            $data1 = $data['name'];
            $data2 = 'Position : '; //Sesuain Controller
            $detail = $caption . $data2 . $data1;
            // dd($data);
            Jabatan::create($data);

            LogActivity::create([
                'log_id' => $logid,
                'user_id' => $this->userid,
                'activity' => 'Create',
                'description' => $detail,
            ]);

            DB::commit();
            return redirect()->route('mst_post.index')->with('success', 'Data created successfully...');
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
    public function show(Jabatan $jabatan) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $decryptID = Crypt::decryptString($id);
        $dept = Department::all();
        $data = Jabatan::find($decryptID);
        // dd($data);

        return view('mstr_jabatan.edit', compact('data', 'dept'));
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
                'post_name' => 'required',
                'post_code' => 'required',
                'departmen' => 'required',
            ]
        );

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator)->with('error', 'Error updated Data...');
        try {
            DB::beginTransaction();

            $data['name'] = $request->post_name;
            $data['code'] = $request->post_code;
            $data['department_id'] = $request->departmen;

            $caption = config('custom.cap_update_master');
            $data1 = $data['name']; //Sesuain Key
            $data2 = 'Position : '; //Sesuain Controller
            $detail = $caption . $data2 . $data1;

            Jabatan::whereId($id)->update($data);

            logActivity::create([
                'log_id' => $idlog,
                'activity' => 'Update',
                'description' => $detail,
                'user_id' => $this->userid,
            ]);

            DB::commit();
            return redirect()->route('mst_post.index')->with('success', 'Data updated successfully...');
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
            $data = Jabatan::find($id);

            $caption = config('custom.cap_delete_master');
            $data1 = $data['name']; //Sesuain Key
            $data2 = 'Position : '; //Sesuain Controller
            $detail = $caption . $data2 . $data1;
            // dd($detail);
            if ($data) {
                $data->delete();
            }
            logActivity::create([
                'log_id' => $idlog,
                'activity' => 'Delete',
                'description' => $detail,
                'user_id' => $this->userid,
            ]);
            DB::commit();
            return redirect()->route('mst_post.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
