<?php

namespace Src\Auth\Infrastructure\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Src\Auth\Application\DTO\RefreshAuthDTO;
use Src\Shared\Exceptions\BadRequestException;

class RefreshAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }

    public function dto(): RefreshAuthDTO
    {
        return new RefreshAuthDTO(
            $this->input('refresh_token')
        );
    }

    /**
     * @throws BadRequestException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestException();
    }
}
