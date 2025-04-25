<?php

namespace Src\Balance\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Balance\Application\DTO\CreateBalanceDTO;

class CreateBalanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_user' => 'required|uuid',
            'to_user'   => 'required|uuid',
            'amount'    => 'required|numeric|min:0',
            'currency'  => 'required|string|max:3',
        ];
    }

    public function dto(): CreateBalanceDTO
    {
        return new CreateBalanceDTO(
            $this->string('from_user'),
            $this->string('to_user'),
            $this->float('amount'),
            $this->integer('currency')
        );
    }
}
