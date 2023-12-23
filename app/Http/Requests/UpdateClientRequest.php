<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'              => 'required|string',
            'email'             => 'required|email',
            'card_id'           => 'required|digits:16',
            'address'           => 'required|string',
            'phone_number'      => [
                'required',
                'regex:/^\+?(\d{1,3})?\s?(\()?(\d{3})(?(2)\))[-.\s]?(\d{3})[-.\s]?(\d{4})|(\d{1})?[-.\s]?(\d{3})[-.\s]?(\d{3})[-.\s]?(\d{4})$/'
            ],
            'status'            => 'required|accepted',
        ];
    }
}
