<?php

use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\ProfileController;
use App\Http\Controllers\backend\admin\CategoryController;
use App\Http\Controllers\backend\admin\CourseController;
use App\Http\Controllers\backend\AuthenticationController;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

// frontend 




// backend 
Route::match(['get', 'post'], '/', [AuthenticationController::class, 'login'])->name('login');
// route prefix 
Route::prefix('admin')->group(function () {
    // route name prefix 
    Route::name('admin.')->group(function () {
        //middleware 
        Route::middleware(AdminAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

                 //category
            Route::match(['get', 'post'], 'category/add', [CategoryController::class, 'category_add'])->name('category.add');
            Route::match(['get', 'post'], 'category/edit', [CategoryController::class, 'category_edit'])->name('category.edit');
            Route::get('category/list', [CategoryController::class, 'category_list'])->name('category.list');
            Route::get('category/delete/{id}', [CategoryController::class, 'category_delete'])->name('category.delete');


             Route::match(['get', 'post'], 'course/add', [CourseController::class, 'course_add'])->name('course.add');
            Route::match(['get', 'post'], 'course/edit/{id}', [CourseController::class, 'course_edit'])->name('course.edit');
            Route::get('course/list', [CourseController::class, 'course_list'])->name('course.list');
            Route::get('course/delete/{id}', [CourseController::class, 'course_delete'])->name('course.delete');

        });
    });
});

