<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\ACustomFormRequest;

class NotificationPostRequest extends ACustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize () : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules () : array
    {
        return [
            'type'            => 'required',
            'data'            => 'required',
            'tag_names'       => 'required_without:accountable_ids',
            'accountable_ids' => 'required_without:tag_names',
        ];
    }
}
