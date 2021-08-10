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

    Route::get('/{slug}/{locale?}', [PublicController::class, 'index'])->name('user');
    Route::get("/locale/{id}", [PublicController::class, 'locale'])->name('locale');
});


Route::get('logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('user.login');
});
// Admin specific Routes
Route::name("admin.")->prefix('admin')->group(function () {
    //users
    {
        Route::get("users/{trash?}", [AdminController::class, 'get_users'])->name('users');
        Route::post("users", [AdminController::class, 'new_user'])->name('users.create');
        Route::get("users/{id}/hard", [AdminController::class, 'hard_delete_user'])->name('user.delete.hard');
        Route::get("users/{id}/soft", [AdminController::class, 'soft_delete_user'])->name('user.delete.soft');
    }
    Route::post("settings/admin", [AdminController::class, 'settings'])->name('settings');
});

Route::name("dashboard.")->prefix('admin')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name("dashboard");

    Route::get("settings", function () {
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

// User Login Routes
Route::name("user.")->prefix('user')->group(function () {

    Route::post("settings/user", [UserController::class, 'settings'])->name('settings');
});
