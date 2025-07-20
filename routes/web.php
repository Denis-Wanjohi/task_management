<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;
Route::redirect("/","/tasks");
// get all task
Route::get("/tasks",[TaskController::class,"index"])->name("task.tasks");
// get a single task
Route::get("/task/{id}",[TaskController::class,"show"])->name("task.show");
// create a task
Route::get("/create",[TaskController::class,"create"])->name('task.create');
Route::post("/store",[TaskController::class,"store"])->name("task.store");
// update the task
Route::get("/edit/{id}",[TaskController::class,"edit"])->name("task.edit");
Route::post("/update/{id}",[TaskController::class,"update"])->name("task.update");;
// delete the task
Route::delete("/destroy/{id}",[TaskController::class,"destroy"])->name("task.destroy");

// edit deliverable
Route::post("/update/deliverable/{id}",[TaskController::class,'updateDeliverable'])->name('deliverable.update');
// delete deliverable
Route::post("/destroy/deliverable/{id}",[TaskController::class,'destroyDeliverable'])->name('deliverable.destroy');