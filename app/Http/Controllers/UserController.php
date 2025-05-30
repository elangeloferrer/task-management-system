<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\UserServiceInterface;

class UserController extends Controller
{
    protected $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userService->getAllUsersWithTasks($request->toArray());
    }
}
