<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TaskServiceInterface;

use App\Helpers\ApiResponse;
use App\Helpers\Validations\CreateTaskValidator;
use App\Helpers\Validations\UpdateTaskValidator;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(
        TaskServiceInterface $taskService
    ) {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->taskService->getAllTasks($request->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = CreateTaskValidator::validate($request);
        if ($validator->fails()) {
            return ApiResponse::validationErrors($validator->errors(), 422);
        }

        return $this->taskService->store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->taskService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = UpdateTaskValidator::validate($request);
        if ($validator->fails()) {
            return ApiResponse::validationErrors($validator->errors(), 422);
        }

        return $this->taskService->update($request->toArray(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->taskService->destroy($id);
    }
}
