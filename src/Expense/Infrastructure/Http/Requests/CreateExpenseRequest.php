<?php

namespace Src\Expense\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Src\Expense\Application\DTO\AuthUserDTO;
use Src\Expense\Application\DTO\CreateExpenseDTO;
use Src\Expense\Application\DTO\ExpenseParticipantsListDTO;

class CreateExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payers'       => 'required|array',
            'payers.*'     => 'required|string',
            'payees'       => 'required|array',
            'payees.*'     => 'required|string',
            'amount'       => 'required|numeric',
            'currency_id'  => 'required|numeric',
            'description'  => 'required|string',
            'expense_date' => 'required|date',
            'category_id'  => 'required|numeric',
            'note'         => 'string',
        ];
    }

    public function dto(): CreateExpenseDTO
    {
        return new CreateExpenseDTO(
            new AuthUserDTO(
                Auth::id(),
                Auth::user()->uuid
            ),
            $this->getPayers(),
            $this->getPayees(),
            $this->float('amount'),
            $this->integer('currency_id'),
            $this->string('description'),
            $this->string('date'),
            $this->integer('category_id') ?: null,
            $this->string('note') ?: null
        );
    }

    private function getPayers(): ExpenseParticipantsListDTO
    {
        return new ExpenseParticipantsListDTO(
            $this->get('payers')
        );
    }

    private function getPayees(): ExpenseParticipantsListDTO
    {
        return new ExpenseParticipantsListDTO(
            $this->get('payees')
        );
    }
}
