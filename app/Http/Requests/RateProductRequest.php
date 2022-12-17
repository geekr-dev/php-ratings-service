<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'score' => 'required|numberic|between:0,5',
            'comment' => 'somtimes|string',
        ];
    }
}
