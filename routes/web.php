<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\JeuController;
use App\Http\Controllers\LevelsController;
use App\Http\Controllers\MotsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarifsController;
use App\Http\Controllers\ThemesController;
use App\Http\Controllers\UsersController;
use App\Livewire\MyGameComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/jeu', MyGameComponent::class)->name('jeu.index');

    //Route::get('/dashboard/jeu', [JeuController::class, 'index'])->name('jeu.index');
    Route::post('/dashboard/jeu/submit', [JeuController::class, 'submit'])->name('jeu.submit');
    // Dans web.php
    Route::post('/dashboard/jeu/save-game-setup', [GameController::class, 'saveGameSetup'])->name('save.game.setup');
    Route::get('/dashboard/jeu/play-game', [GameController::class, 'playGame'])->name('play.game');

    Route::post('get_words', [JeuController::class, 'getWords'])->name('jeu.mots');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Users
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::post('/update-premium/{user}', [UsersController::class, 'updatePremiumStatus'])->name('update-premium');
    });

    // Tarifs
    Route::prefix('admin/tarifs')->name('admin.tarifs.')->group(function () {
        Route::get('/', [TarifsController::class, 'index'])->name('index');
        Route::get('/create', [TarifsController::class, 'create'])->name('create');
        Route::post('/', [TarifsController::class, 'store'])->name('store');
        Route::get('/{tarif}/edit', [TarifsController::class, 'edit'])->name('edit');
        Route::put('/{tarif}', [TarifsController::class, 'update'])->name('update');
        Route::delete('/{tarif}', [TarifsController::class, 'destroy'])->name('destroy');
    });

    // Levels
    Route::prefix('admin/levels')->name('admin.levels.')->group(function () {
        Route::get('/', [LevelsController::class, 'index'])->name('index');
        Route::get('/create', [LevelsController::class, 'create'])->name('create');
        Route::post('/', [LevelsController::class, 'store'])->name('store');
        Route::get('/{level}/edit', [LevelsController::class, 'edit'])->name('edit');
        Route::put('/{level}', [LevelsController::class, 'update'])->name('update');
        Route::delete('/{level}', [LevelsController::class, 'destroy'])->name('destroy');
    });

    // Correctif: Assurez-vous que la convention de nommage est cohérente
    Route::prefix('admin/theme')->name('admin.theme.')->group(function () {
        Route::get('/', [ThemesController::class, 'index'])->name('index');
        Route::get('/create', [ThemesController::class, 'create'])->name('create');
        Route::post('/', [ThemesController::class, 'store'])->name('store');
        Route::get('/{theme}/edit', [ThemesController::class, 'edit'])->name('edit');
        Route::put('/{theme}', [ThemesController::class, 'update'])->name('update');
        Route::delete('/{theme}', [ThemesController::class, 'destroy'])->name('destroy');
    });

    // Categories
    Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('/', [CategoriesController::class, 'store'])->name('store');
        Route::get('/{categorie}/edit', [CategoriesController::class, 'edit'])->name('edit');
        Route::put('/{categorie}', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/{categorie}', [CategoriesController::class, 'destroy'])->name('destroy');
    });

    // Mots
    Route::prefix('admin/mots')->name('admin.mots.')->group(function () {
        Route::get('/', [MotsController::class, 'index'])->name('index');
        Route::get('/create', [MotsController::class, 'create'])->name('create');
        Route::post('/', [MotsController::class, 'store'])->name('store');
        Route::get('/{mot}/edit', [MotsController::class, 'edit'])->name('edit');
        Route::put('/{mot}', [MotsController::class, 'update'])->name('update');
        Route::delete('/{mot}', [MotsController::class, 'destroy'])->name('destroy');
        Route::post('/import', [MotsController::class, 'import'])->name('import');
    });
});

Route::get('/tarifs', [ProfileController::class, 'showTarifs']);

require __DIR__ . '/auth.php';
