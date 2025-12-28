<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskDataRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
        ];

        // I am using the same request for create and update, in case of create, the status field is required,
        // but in case of update, it would be optional. so, I am using the http methods to change its 
        // validation rules.
        if ($this->isMethod('post')) {
            $rules['status'] = ['required', 'string', Rule::enum(TaskStatus::class)];
        } elseif ($this->isMethod('put')) {
            $rules['status'] = ['sometimes', 'string', Rule::enum(TaskStatus::class)];
        }

        return $rules;
    }
}
