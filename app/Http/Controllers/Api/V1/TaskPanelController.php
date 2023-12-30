<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TaskPanel\StoreTaskRequest;
use App\Http\Requests\Api\V1\TaskPanel\UpdateTaskRequest;
use App\Http\Resources\Api\V1\TaskPanel\TaskResource;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskPanelController extends Controller
{
    /**
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request,TaskRepository $taskRepository): JsonResponse
    {
        $validated = $request->validated();
        $userId = $request->user()->id;
        $validated['reporter_id'] = $userId;
        $task = $taskRepository->create($validated);
        return Response::created(new TaskResource($task->load('assignedUser')),__('taskpanel.created'));
    }

    /**
     * @param UpdateTaskRequest $request
     * @param int $taskId
     * @param TaskRepository $taskRepository
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, int $taskId,TaskRepository $taskRepository): JsonResponse
    {
        $validated = $request->validated();
        $task = $taskRepository->first($taskId);

        if (!$task) {
            return Response::notFound(__('taskpanel.not_found'));
        }

        $taskRepository->update($task,$validated);
        return Response::success(new TaskResource($task->load('assignedUser')),__('taskpanel.updated'));
    }

}
