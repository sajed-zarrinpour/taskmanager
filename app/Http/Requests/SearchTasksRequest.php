<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchTasksRequest extends FormRequest
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
        return [
            'page' => 'sometimes|integer|gt:0',
            'column' => [
                'sometimes', 'string',
                Rule::in(['status', 'due_date']),
            ],
            'value' => 'required_with:column',
            'order_by' => [
                'sometimes', 'string',
                Rule::in(['id', 'title', 'user_id', 'status', 'description', 'due_date','created_at', 'deleted_at', 'updated_at']),
            ],
            'direction' => [
                'sometimes', 'string',
                Rule::in('asc', 'desc'),
            ],
        ];
    }
}
