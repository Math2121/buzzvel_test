<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'description' => 'string',
            'file' => 'file',
            'status' =>  [
                Rule::in(['completed', 'not_completed']),
            ],
            'dates' => 'required|date_format:Y-m-d',
            'user' => 'string|max:255',
        ];
    }


    public function messages(): array
    {
        return [

            'title.string' => 'The title field must be a string.',
            'title.max' => 'The title field must not exceed :max characters.',

            'description.string' => 'The description field must be a string.',

            'file.file' => 'The file field must be a valid file.',

            'status.in' => 'The status field must be completed or not_completed.',
            'dates.required' => 'The dates field is required.',
            'dates.date_format' => 'The dates field must be a valid date.',

            'user.string' => 'The user field must be a string.',
            'user.max' => 'The user field must not exceed :max characters.',
        ];
    }
}
