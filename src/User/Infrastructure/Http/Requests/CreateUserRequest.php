<?php

namespace Src\User\Infrastructure\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Src\Shared\Exceptions\BadRequestException;
use Src\User\Application\DTO\CreateUserDTO;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'email'    => 'required|email',
            'password' => 'string',
            'uuid'     => 'string',
        ];
    }

    public function dto(): CreateUserDTO
    {
        return new CreateUserDTO(
            email: $this->input('email'),
            name: $this->input('name'),
            password: $this->input('password'),
            uuid: $this->input('uuid')
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
