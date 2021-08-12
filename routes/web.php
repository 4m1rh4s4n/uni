<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name("public.")->group(function () {
    Route::get('login', [AuthController::class, 'login_form'])->name('login.form');
    Route::get('register', [AuthController::class, 'register_form'])->name('register.form');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    });

    Route::get('u/{slug}/{locale?}', [PublicController::class, 'index'])->name('user');
});

Route::prefix('admin')->group(function () {
    Route::name("dashboard.")->group(function () {
        Route::get('/dashboard', function () {
            if (Auth::guest()) {
                return redirect()->route('public.login.form');
            }
            return view('dashboard');
        })->name('dashboard');
        Route::get("settings", function () {
            if (Auth::guest()) {
                return redirect()->route('public.login.form');
            }
            if (session("role") == "admin") {
                $id = Auth::guard("admin")->id();
                $user = Admin::find($id);
            } else {
                $id = Auth::id();
                $user = User::find($id);
            }
            return view("account", ['user' => $user]);
        })->name("account");
    });
    Route::name("user.")->group(function () {
        Route::post("settings/user", [UserController::class, 'settings'])->name('settings');
        Route::get('profile/{lang?}', [UserController::class, 'profile'])->name('profile');
        Route::post('profile/{lang?}', [UserController::class, 'setProfile'])->name('profile.set');

        Route::get("publications", [UserController::class, 'pubs_list'])->name('publications');
        Route::post("publications", [UserController::class, 'pubs'])->name('publications.post');
        Route::post("publications/edit", [UserController::class, 'pubs_edit'])->name('publications.edit');

        Route::get("awards", [UserController::class, 'awards_list'])->name('awards');
        Route::post("awards", [UserController::class, 'awards'])->name('awards.post');
        Route::post("awards/edit", [UserController::class, 'awards_edit'])->name('awards.edit');

        Route::get('delete/{table}/{id}', [UserController::class, 'delete'])->name('delete');
    });
    Route::name("admin.")->group(function () {
        //users managment
        {
            Route::get("users/{trash?}", [AdminController::class, 'get_users'])->name('users');
            Route::post("users", [AdminController::class, 'new_user'])->name('users.create');
            Route::get("users/{id}/hard", [AdminController::class, 'hard_delete_user'])->name('user.delete.hard');
            Route::get("users/{id}/soft", [AdminController::class, 'soft_delete_user'])->name('user.delete.soft');
        }
        Route::post("settings/admin", [AdminController::class, 'settings'])->name('settings');
    });
});
