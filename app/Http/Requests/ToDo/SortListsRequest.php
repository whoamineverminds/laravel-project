<?php

namespace App\Http\Requests\ToDo;

use Illuminate\Foundation\Http\FormRequest;

class SortListsRequest extends FormRequest
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
            'type' => 'integer',
            'offset' => 'integer',
            'count' => 'integer'
        ];
    }
}
