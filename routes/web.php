<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Models\Project;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// الخدمات
Route::get('/services', [HomeController::class, 'services'])
    ->name('services.index');

// من نحن
Route::get('/about', [HomeController::class, 'about'])
    ->name('about');

// معرض الأعمال
Route::get('/projects', [HomeController::class, 'projects'])
    ->name('projects.index');
Route::get('/projects/{project}', function (Project $project) {
    return view('frontend.projects.show', compact('project'));
})->name('projects.show');

// المدونة
Route::get('/blog', [ArticleController::class, 'index'])
    ->name('articles.index');

// قراءة مقال
Route::get('/blog/{slug}', [ArticleController::class, 'show'])
    ->name('articles.show');

// التواصل
Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');

// إرسال طلب تسعير
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');