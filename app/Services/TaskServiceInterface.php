<?php

namespace App\Services;

interface TaskServiceInterface
{
    public function getAllTasksByUser($data);
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
