<?php

namespace App\Http\Controllers;

use App\Models\DefaultRole;
use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogActivity;
use App\Models\MenuCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Traits\Loggable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
        $datax = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->join('department', 'department.id', '=', 'users.department_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'department.name as dept',
                'roles.name as role',
                'users.created_at as date',
                'users.avatar'
            )
            ->get();


        // $datax = User::get();

        return view('manage_user.index', compact('datax'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menud = MenuCategory::with(['menus' => function ($query) {
            $query->orderBy('no_urut');
        }])->orderBy('no_urut')->get();
        $dept = Department::get();
        $roled = Role::get()->all();
        $defrole = DefaultRole::get();
        $isAdmin = auth()->user()->role;

        return view('manage_user.create', compact('menud', 'roled', 'defrole', 'isAdmin', 'dept'));
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
                'email' => 'required|email',
                'name' => 'required',
                'phone' => 'required|min:11|max:13',
                'role' => 'required',
                'department' => 'required',
            ]
        );

        $role = $request->input('role');
        $dept = $request->input('department');
        // dd($dept);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput() // Menyimpan input agar form terisi dengan data sebelumnya
                ->withErrors($validator) // Menyimpan error validasi
                ->with('error', 'Error created Data...'); // Menyimpan pesan error umum
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => Hash::make('inipassword'),
                'department_id' => $dept,
                'created' => $this->userid,
                'role_id' => $role,
                'avatar' => 'pria6.svg',
            ]);

            // Dapatkan ID user yang baru dibuat
            $dataId = $user->id;

            if ($request->has('menus')) {
                foreach ($request->menus as $menusId) {
                    RoleMenu::create([
                        'user_id' => $dataId,
                        'menu_id' => $menusId,
                    ]);
                }
            }

            // LogActivity
            $this->logActivity($logid, $this->userid, 'Master User', 'Created', $request->email, 'Menambahkan Master User.');


            DB::commit();
            return redirect()->route('mng_user.index')->with('success', 'Data created successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == 23000 || $e->getCode() == 1062) {
                return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar, Gunakan Email Lain!');
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
    public function edit(Request $request, $id)
    {
        $decryptID = Crypt::decryptString($id);

        $data = User::find($decryptID);

        $roled = Role::get()->all();
        $dept = Department::get()->all();
        $defrole = DefaultRole::get();
        $isAdmin = auth()->user()->role;
        $menud = MenuCategory::with(['menus' => function ($query) {
            $query->orderBy('no_urut');
        }])->orderBy('no_urut')->get();
        $userMenus = DB::table('role_menu') // Ambil daftar menu_id dari role_menu
            ->where('user_id', $decryptID)
            ->pluck('menu_id')
            ->toArray();

        // dd($userMenus);

        return view('manage_user.edit', compact('data', 'roled', 'isAdmin', 'menud', 'defrole', 'userMenus', 'dept'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $logid = IdGenerator::generate(['table' => 'log_activities', 'length' => '11', 'prefix' => 'log-', 'field' => 'log_id']);
        $decryptID = Crypt::decryptString($id);
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'name' => 'required',
                'phone' => 'required|min:11|max:13',
                'department' => 'required',
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

            // Ambil data user berdasarkan ID
            $user = User::findOrFail($decryptID);

            // Cek apakah ada perubahan data
            $changes = [];
            if ($user->email !== $request->email)
                $changes['email'] = $request->email;
            if ($user->name !== $request->name)
                $changes['name'] = $request->name;
            if ($user->phone !== $request->phone)
                $changes['phone'] = $request->phone;
            if ($user->department !== $request->department)
                $changes['department_id'] = $request->department;
            if ($user->role !== $request->role)
                $changes['role_id'] = $request->role;

            // Jika tidak ada perubahan, langsung kembalikan dengan notifikasi
            if (empty($changes) && !$request->has('menus')) {
                return redirect()->route('mng_user.index')->with('info', 'Tidak ada perubahan data.');
            }

            // Lakukan update hanya jika ada perubahan
            if (!empty($changes)) {
                $user->update($changes);
                // Hapus menu lama
                RoleMenu::where('user_id', $decryptID)->delete();

                $newMenus = $request->menus; // Menu dari form
                // Simpan menu baru
                foreach ($newMenus as $menuId) {
                    RoleMenu::create([
                        'user_id' => $decryptID,
                        'menu_id' => $menuId,
                    ]);
                }

                $this->logActivity($logid, $this->userid, 'Master User', 'Updated', $request->email, 'Perubahan Master User.');
            }

            DB::commit();
            return redirect()->route('mng_user.index')->with('success', 'Data updated successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == 23000 || $e->getCode() == 1062) {
                return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar, gunakan email lain!');
            }
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

            $data = User::find($id);

            $caption = config('custom.cap_delete_master');
            $data1 = $data['email']; //Sesuain Key
            $data2 = 'User : '; //Sesuain Controller
            $detail = $caption . $data2 . $data1;

            // dd($detail);

            if ($data) {
                $data->delete();
            }

            logActivity::create([
                'log_id' => $idlog,
                'activity' => 'Deleted',
                'description' => $detail,
                'user_id' => $this->userid,
            ]);

            DB::commit();
            return redirect()->route('mng_user.index')->with('success', 'Data deleted successfully...');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
