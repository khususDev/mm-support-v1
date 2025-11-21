<?php

namespace App\Http\Controllers;

use App\Models\DefaultRole;
use App\Models\Role;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\LogActivity;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class AccessController extends Controller
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
        $user = auth()->user()->role->name;

        $data = DB::table('role_menu')
            ->join('users', 'users.id', '=', 'role_menu.user_id')
            ->join('menus', 'menus.id', '=', 'role_menu.menu_id')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->join('status', 'status.id', '=', 'role_menu.status')
            ->select(
                'users.id as id',
                'users.name as name',
                'roles.name as role',
                'status.name as status',
                DB::raw('GROUP_CONCAT(menus.name SEPARATOR ", ") as menus')
            )
            ->groupBy('users.id', 'users.name', 'roles.name', 'status.name')
            ->get();

        return view('manage_access.index', compact('data', 'user'));
    }

    public function create()
    {
        $userd = User::get();
        $menud = Menu::get();
        $roled = Role::get();
        $defrole = DefaultRole::get();
        $isAdmin = Auth()->user()->role;

        return view('manage_access.create', compact('userd', 'isAdmin', 'menud', 'roled', 'defrole'));
    }

    public function store(Request $request)
    {
        $logid = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        $request->validate([
            'username' => 'required',
            'role' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $data['username'] = $request->username;
            $data['role'] = $request->role;

            $caption = config('custom.cap_create_permission');
            $data1 = $data['username'];
            $data2 = 'Permission : ';
            $detail = $caption . $data2 . $data1;

            if ($request->has('menus')) {
                foreach ($request->menus as $menusId) {
                    RoleMenu::create([
                        'user_id' => $data['username'],
                        'menu_id' => $menusId,
                    ]);
                }
            }

            // LogActivity
            $this->logActivity($logid, $this->userid, 'Master Access', 'Created', $request->username, 'Access ditambahkan');


            DB::commit();
            return redirect()->route('mng_access.index')->with('success', 'Permission berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
    }

    public function edit(Request $request, $id)
    {
        $decryptID = Crypt::decryptString($id);
        // $data = User::find($decryptID);
        $data = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $decryptID)  // Spesifik tabel untuk kolom id
            ->select(
                'users.*',
                'roles.name as role_name'  // Beri alias untuk menghindari konflik
            )
            ->first();  // Gunakan first() untuk single record

        // dd($data);
        $userd = User::get();
        $menud = Menu::get();
        $roled = Role::get();
        $defrole = DefaultRole::get();
        $isAdmin = Auth()->user()->role;
        $uuid = $decryptID;

        $userMenus = DB::table('role_menu')
            ->where('user_id', $decryptID)
            ->pluck('menu_id')
            ->toArray();

        return view('manage_access.edit', compact('data', 'userd', 'isAdmin', 'menud', 'roled', 'defrole', 'uuid', 'userMenus'));
    }

    public function update(Request $request, string $id)
    {
        $logid = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);

        $validator = Validator::make(
            $request->all(),
            [
                'role' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Error updating data...');
        }

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            $changes = [];
            if ($user->role_id !== $request->role)
                $changes['role_id'] = $request->role;

            if (empty($changes) && !$request->has('menus')) {
                return redirect()->route('mng_access.index')->with('info', 'Tidak ada perubahan data.');
            }

            if (!empty($changes)) {
                $user->update($changes);
            }

            if ($request->has('menus')) {
                $newMenus = $request->menus;
                $oldMenus = RoleMenu::where('user_id', $id)->pluck('menu_id')->toArray(); // Menu lama

                if ($newMenus !== $oldMenus) {
                    RoleMenu::where('user_id', $id)->delete();

                    foreach ($newMenus as $menuId) {
                        RoleMenu::create([
                            'user_id' => $id,
                            'menu_id' => $menuId,
                        ]);
                    }
                }
            }

            if (!empty($changes) || $newMenus !== $oldMenus) {
                // LogActivity
                $this->logActivity($logid, $this->userid, 'Master Access', 'Updated', $id, 'Access diperbaharui');
            }

            DB::commit();
            return redirect()->route('mng_access.index')->with('success', 'Data updated successfully...');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $idlog = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);
        // dd($id);
        try {
            DB::beginTransaction();

            $data = RoleMenu::where('user_id', $id)->get(); // Ambil data terlebih dahulu

            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Data not found!');
            }

            // Hapus data setelah diambil
            RoleMenu::where('user_id', $id)->delete();

            // LogActivity
            $this->logActivity($idlog, $this->userid, 'Master Access', 'Deleted', $id, 'Access dihapus');

            DB::commit();
            return redirect()->route('mng_access.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
