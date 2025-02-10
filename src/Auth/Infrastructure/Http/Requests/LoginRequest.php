<?php

namespace Src\Auth\Infrastructure\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Src\Auth\Application\DTO\LoginDTO;
use Src\Shared\Exceptions\BadRequestException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function dto(): LoginDTO
    {
        return new LoginDTO(
            email: $this->input('email'),
            password: $this->input('password')
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
