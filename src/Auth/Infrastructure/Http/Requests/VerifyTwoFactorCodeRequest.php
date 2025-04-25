<?php

namespace Src\Auth\Infrastructure\Http\Requests;

use Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Src\Auth\Application\DTO\VerifyTwoFactorCodeDTO;
use Src\Shared\Exceptions\BadRequestException;

class VerifyTwoFactorCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|digits:6',
        ];
    }

    public function dto(): VerifyTwoFactorCodeDTO
    {
        return new VerifyTwoFactorCodeDTO(
            Auth::id(),
            $this->bearerToken(),
            $this->input('code')
        );
    }

    /**
     * @throws BadRequestException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = [
            'errors' => $validator->errors()->toArray(),
        ];

        throw new BadRequestException($errors);
    }
}
