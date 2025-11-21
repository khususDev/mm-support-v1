<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Traits\Loggable;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    // protected $userid = Auth::user()->id;
    protected $userid;
    use Loggable;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::check() ? Auth::user()->id : null;
            return $next($request);
        });
    }
    public function index()
    {
        // $data = Menu::get();
        $data = DB::table('menus AS child')
            ->select(
                'child.id AS id',
                'menu_categories.name AS mname',
                'child.name AS name',
                'parent.name AS pname',
                'child.url AS url',
                'child.no_urut AS urut',
                'child.icon AS icon',
                'child.created AS created',
                'child.created_at AS created_at'
            )
            ->leftJoin('menus AS parent', 'child.parent_id', '=', 'parent.id')
            ->leftJoin('menu_categories', 'menu_categories.id', '=', 'child.category_id')
            ->orderByRaw("CASE WHEN mname IS NULL OR mname = '' then 1 ELSE 0 END")
            ->orderBy(('mname'))
            ->orderByRaw("CASE WHEN urut IS NULL OR urut = '' then 1 ELSE 0 END")
            ->orderBy('urut')
            ->orderBy('pname')
            ->get();

        // dd($data);

        return view('sistm_menu.index', compact('data'));
    }

    public function create()
    {
        $menu = Menu::where('url', '#')->get();
        $categori = MenuCategory::where('status', '1')->get();
        // dd($categori);


        return view('sistm_menu.create', compact('menu', 'categori'));
    }

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
                'url' => 'required',
            ]
        );

        $menu = $request->input('parent');

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Error created Data...');
        }

        try {
            DB::beginTransaction();

            $data['name'] = $request->name;
            $data['category_id'] = $request->kategori;
            $data['url'] = $request->url;
            $data['icon'] = $request->icon;
            $data['parent_id'] = $menu;
            $data['created'] = $this->userid;

            Menu::create($data);

            $this->logActivity($logid, $this->userid, 'Master Menu', 'Created', $request->name, 'Master menu ditambahkan');

            DB::commit();
            return redirect()->route('sys_menu.index')->with('success', 'Data created successfully...');
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

        $data = Menu::find($decryptID);
        $categories = MenuCategory::all();

        // dd($data);

        return view('sistm_menu.edit', compact('data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $idlog = IdGenerator::generate([
            'table' => 'log_activities',
            'field' => 'log_id',
            'length' => 11,
            'prefix' => 'log-'
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'url' => 'required',
            ]
        );

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator)->with('error', 'Error updated Data...');
        try {
            DB::beginTransaction();

            $data['name'] = $request->name;
            $data['category_id'] = $request->kategori;
            $data['no_urut'] = $request->urut;
            $data['url'] = $request->url;
            $data['parent_id'] = $request->parent;
            $data['icon'] = $request->icon;

            Menu::whereId($id)->update($data);

            $this->logActivity($idlog, $this->userid, 'Master Menu', 'Updated', $id, 'Master menu diperbaharui');

            DB::commit();
            return redirect()->route('sys_menu.index')->with('success', 'Data updated successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        try {
            DB::beginTransaction();
            $data = Menu::find($id);

            if ($data) {
                $data->delete();
            }

            $this->logActivity($idlog, $this->userid, 'Master Menu', 'Deleted', $id, 'Master menu dihapus');

            DB::commit();
            return redirect()->route('sys_menu.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
