<?php

namespace App\Http\Requests\Api\V1\TaskPanel;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','unique:tasks,name'],
            'description' => ['sometimes','string'],
            'status' => ['sometimes',Rule::in(['todo','in-progress','suspended','cancelled','done'])]
        ];
    }
}
