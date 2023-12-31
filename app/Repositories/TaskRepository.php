<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{

    /**
     * @param array $taskData
     * @return object
     */
    public function create(array $taskData): object
    {
        return Task::create($taskData);
    }

    /**
     * @param Task $task
     * @param $taskData
     * @return bool
     */
    public function update(Task $task , $taskData): bool
    {
        return $task->update($taskData);
    }


    /**
     * @param int $taskId
     * @return mixed
     */
    public function first(int $taskId): mixed
    {
        return Task::where('id', $taskId)->first();
    }
}