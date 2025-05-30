<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

use App\Helpers\ApiResponse;

class UserService implements UserServiceInterface
{

    protected $userRepository;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsersWithTasks($payload)
    {
        $items = $this->userRepository->getAllUsersWithTasks($payload['per_page']);
        $data = [
            'users' => $items,
            'pagination' => [
                'current_page' => $items->currentPage(),
                'next_page_url' => $items->nextPageUrl(),
                'prev_page_url' => $items->previousPageUrl(),
                'per_page' => $items->perPage(),
                'total_items' => $items->total(),
                'total_pages' => $items->lastPage(),
            ],
        ];
        return ApiResponse::success($data, "Successfully fetched data", 200);
    }
}
