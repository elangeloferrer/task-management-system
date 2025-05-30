<?php

namespace App\Repositories;

use App\AbstractBases\AbstractBaseRepository;

use App\Http\Resources\UserResource;

use App\Models\User;


class UserRepository extends AbstractBaseRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getAllUsers($page = 1, $perPage = 10, $keywords = "", $filterBy = "")
    {

        $query = $this->model->whereHas('role', fn($q) => $q->where('code', 'user'));

        $collection = $query->paginate($perPage);

        return UserResource::collection($collection);
    }
}
