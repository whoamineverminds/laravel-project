<?php

namespace App\Http\Requests\ToDo;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:32',
            'description' => 'max:256',
            'priority' => 'required|integer|min:1|max:5'
        ];
    }
}
