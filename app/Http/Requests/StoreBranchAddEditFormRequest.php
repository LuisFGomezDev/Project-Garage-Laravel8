<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchAddEditFormRequest extends FormRequest
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
            'branchname' => 'required|max:100|regex:/^[(a-zA-Z0-9\s)\p{L}]+$/u',
            'contactnumber' => 'required|min:6|max:16|regex:/^[- +()]*[0-9][- +()0-9]*$/',
            //'email' => 'required|email|unique:users,email,'.$this->id,
            //'email' => 'required|email|unique:branches,branch_email,'.$this->id,
            'email' => 'required|email',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'country_id' => 'required',
            'address' => 'required|max:200|regex:/^[(a-zA-Z0-9\s)\p{L}]+$/u',
        ];
    }


    public function messages()
    {
        return [
            'branchname.required' => trans('app.Branch name is required.'),
            'branchname.max' => trans('app.Branch name should not more than 100 character.'),
            'branchname.regex'  => trans('app.Only alphanumeric, space, dot, underscore, hyphen and @ are allowed.'),
            
            'contactnumber.required' => trans('app.Contact number is required.'),
            'contactnumber.min' => trans('app.Contact number minimum 6 digits.'),
            'contactnumber.max' => trans('app.Contact number maximum 16 digits.'),
            'contactnumber.regex' => trans('app.Contact number must be number, plus, minus and space only.'),

            'email.required' => trans('app.Email is required.'),
            'email.email'  => trans('app.Please enter a valid email address. Like : sales@dasinfomedia.com'),
            'email.unique' => trans('app.Email you entered is already registered.'),            
        
            'image.mimes' => trans('app.Image must be a file of type: Jpg, Jpeg and Png.'),

            'country_id.required' => trans('app.Country field is required.'),

            'address.required' => trans('app.Address is required.'),
            'address.max' => trans('app.Address should not more than 200 character.'),
            'address.regex'  => trans('app.Only alphanumeric, space, dot, underscore, hyphen and @ are allowed.'),
        ];

    }
}
