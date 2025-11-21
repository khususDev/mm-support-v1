<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\MenuCategory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // $category = MenuCategory::all();
        $category = MenuCategory::orderBy('no_urut')->get();

        $menus = Menu::whereNull('parent_id')
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with([
                'children' => function ($query) use ($user) {
                    $query->whereHas('users', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->orderBy('no_urut'); // Urutkan submenu berdasarkan no_urut
                }
            ])
            ->orderBy('no_urut') // Urutkan menu utama berdasarkan no_urut
            ->get();

        // $menus = Menu::whereNull('parent_id')
        //     ->with(['children' => function ($query) {
        //         $query->orderBy('no_urut');
        //     }])
        //     ->orderBy('no_urut')
        //     ->get();

        $documentData = DB::table('documents')
            ->join('master_docs', 'documents.jenis_document_id', '=', 'master_docs.id')
            ->select('master_docs.name AS jenis', DB::raw('count(*) as total'))
            ->groupBy('jenis')
            ->get();

        $departmentData = DB::table('documents')
            ->join('department', 'documents.department_id', '=', 'department.id')
            ->select('department.name AS department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->get();
        // dd($documentData);

        $avatars = [
            'avatar-1.png',
            'avatar-2.png',
            'avatar-3.png',
            'avatar-4.png',
            'avatar-5.png'
        ];

        $conUser = DB::table('users')->count();
        $conDocs = DB::table('documents')->count();
        $logs = DB::table('log_activities')
            ->join('users', 'log_activities.user_id', '=', 'users.id')
            ->select('log_activities.log_id as id', 'log_activities.action as activity', 'log_activities.description as description', 'users.name as user_name', 'log_activities.created_at')
            ->orderBy('log_activities.created_at', 'desc')
            ->get()
            ->map(function ($log) use ($avatars) {
                $log->avatar = $avatars[array_rand($avatars)]; // Pilih avatar random
                return $log;
            });

        foreach ($logs as $log) {
            $log->time_ago = Carbon::parse($log->created_at)->diffForHumans();
        }
        // dd($menus);

        return view('dashboard.index', compact('menus', 'category', 'documentData', 'conUser', 'conDocs', 'departmentData', 'logs'));
    }
}
