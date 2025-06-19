<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
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

// Rota inicial (landing page)
Route::get('/', function () {
    return view('welcome');
});

// Rotas do Dashboard (já vem com Laravel Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas autenticadas e verificadas
Route::middleware('auth', 'verified')->group(function () {
    // Rotas do Perfil do Usuário (Laravel Breeze modificado)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rota para visualização de perfis de outros usuários
    // Isso permite ver o perfil de qualquer usuário pelo ID.
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Rotas para Grupos
    Route::resource('groups', GroupController::class);

    // Rotas para Músicas
    Route::resource('musics', MusicController::class);

    // Rotas para Eventos
    Route::resource('events', EventController::class);

    // Rotas de Participação em Eventos
    Route::post('events/{event}/participate', [EventController::class, 'participate'])->name('events.participate');
    Route::post('events/{event}/cancel', [EventController::class, 'cancelParticipation'])->name('events.cancel');

    // Rotas para Avaliações (Ratings)
    Route::post('musics/{music}/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::put('ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');


    // -------------------------------------------------------------
    // Rotas de Administração (Protegidas por Policies/Gates)
    // Usaremos 'can:manage-users' e 'can:manage-permissions'
    // Você deve definir esses Gates/Policies no AuthServiceProvider.php
    // -------------------------------------------------------------

    // Gerenciamento de Usuários
    Route::middleware(['can:manage-users'])->group(function () {
        Route::resource('users', UserController::class); // CRUD completo para usuários
        // Rotas para gerenciar permissões de um usuário específico
        Route::get('users/{user}/permissions', [UserController::class, 'editPermissions'])->name('users.permissions.edit');
        Route::put('users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update');
    });

    // Gerenciamento de Permissões (para criar/editar/deletar permissões em si)
    Route::middleware(['can:manage-permissions'])->group(function () {
        Route::resource('permissions', PermissionController::class); // CRUD completo para permissões
    });

    // Note: If you want 'admin' middleware as stated in your PDF,
    // you would define it in app/Http/Kernel.php and assign it to a group
    // or specifically to routes, and then change 'can:...' to 'admin'.
    // For RBAC with policies/gates, 'can' is often preferred.

});

// Inclui as rotas de autenticação padrão do Breeze
require __DIR__.'/auth.php';