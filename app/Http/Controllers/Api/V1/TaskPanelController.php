<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TaskPanel\StoreTaskRequest;
use App\Http\Resources\Api\V1\TaskPanel\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskPanelController extends Controller
{
    /**
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $userId = $request->user()->id;
        $validated['user_id'] = $userId;
        $task = Task::create($validated);
        return Response::created(new TaskResource($task));
    }

}
