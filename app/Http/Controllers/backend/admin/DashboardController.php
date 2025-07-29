<?php

namespace App\Http\Controllers\backend\admin;


use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller implements HasMiddleware
{

  public static function middleware(): array
  {
    return [
      BackendAuthenticationMiddleware::class,
      AdminAuthenticationMiddleware::class
    ];
  }

  public function dashboard()
  {
    $data = array();
    $data['total_course'] = DB::table('courses')->count();
    $data['active_menu'] = 'dashboard';
    $data['page_title'] = 'Dashboard';
    return view('backend.admin.pages.dashboard', compact('data'));
  }
}
