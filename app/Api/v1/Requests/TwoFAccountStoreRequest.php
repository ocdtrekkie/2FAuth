<?php

namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TwoFAccountStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service' => 'nullable|string|regex:/^[^:]+$/i',
            'account' => 'required|string|regex:/^[^:]+$/i',
            'icon' => 'nullable|string',
            'otp_type' => 'required|string|in:totp,hotp',
            'secret' => ['string', 'bail', new \App\Rules\IsBase32Encoded],
            'digits' => 'nullable|integer|between:6,10',
            'algorithm' => 'nullable|string|in:sha1,sha256,sha512,md5',
            'period' => 'nullable|integer|min:1',
            'counter' => 'nullable|integer|min:0',
        ];
    }
}
