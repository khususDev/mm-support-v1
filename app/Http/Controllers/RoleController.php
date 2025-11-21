<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
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
        $data = Role::get();
        $data = DB::table('roles as role')
            ->join('users', 'role.created', '=', 'users.id')
            ->select(
                'role.id as id',
                'role.name as name',
                'users.name as created_name',
                'role.created_at as date'
            )
            ->get();

        return view('manage_roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manage_roles.create');
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
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Error created Data...');
        }

        try {
            DB::beginTransaction();

            $data['name'] = $request->name;
            $data['created'] = $this->userid;

            $caption = config('custom.cap_create_master');
            $data1 = $data['name'];
            $data2 = 'Role : ';
            $detail = $caption . $data2 . $data1;

            Role::create($data);
            logActivity::create([
                'log_id' => $logid,
                'user_id' => $this->userid,
                'activity' => 'Create',
                'description' => $detail,
            ]);

            DB::commit();
            return redirect()->route('mng_role.index')->with('success', 'Data created successfully...');
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

        $data = Role::find($decryptID);

        return view('manage_roles.edit', compact('data'));
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
            ]
        );

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator)->with('error', 'Error updated Data...');
        try {
            DB::beginTransaction();

            $data['name'] = $request->name;

            $caption = config('custom.cap_update_master');
            $data1 = $data['name'];
            $data2 = 'Role : ';
            $detail = $caption . $data2 . $data1;

            Role::whereId($id)->update($data);

            logActivity::create([
                'log_id' => $idlog,
                'activity' => 'Update',
                'description' => $detail,
                'user_id' => $this->userid,
            ]);

            DB::commit();
            return redirect()->route('mng_role.index')->with('success', 'Data updated successfully...');
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
            $data = Role::find($id);

            $caption = config('custom.cap_delete_master');
            $data1 = $data['name'];
            $data2 = 'Role : ';
            $detail = $caption . $data2 . $data1;

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
            return redirect()->route('mng_role.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
