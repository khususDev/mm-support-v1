<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
        $data = MenuCategory::all();

        return view('mstr_category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mstr_category.create');
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
            $data['status'] = '1';

            MenuCategory::create($data);

            $this->logActivity($logid, $this->userid, 'Master Menu Category', 'Created', $request->name, 'Master menu category ditambahkan');

            DB::commit();
            return redirect()->route('menucategory.index')->with('success', 'Data created successfully...');
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
    public function show(MenuCategory $menuCategory)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptID = Crypt::decryptString($id);

        $data = MenuCategory::find($decryptID);

        return view('mstr_category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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

            MenuCategory::whereId($id)->update($data);

            $this->logActivity($idlog, $this->userid, 'Master Menu Category', 'Updated', $id, 'Master menu category diperbaharui');

            DB::commit();
            return redirect()->route('menucategory.index')->with('success', 'Data updated successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        try {
            DB::beginTransaction();
            $data = MenuCategory::find($id);

            if ($data) {
                $data->delete();
            }

            $this->logActivity($idlog, $this->userid, 'Master Menu Category', 'Deleted', $id, 'Master menu category dihapus');

            DB::commit();
            return redirect()->route('menucategory.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
