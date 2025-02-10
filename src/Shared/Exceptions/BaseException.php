<?php

namespace Src\Shared\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class BaseException extends Exception
{
    protected int $statusCode;
    protected string $errorCode;
    protected array $replace;
    protected array $extraParameters;

    public function __construct(string $errorCode, int $statusCode = 500, array $replace = [], array $extraParameters = [])
    {
        parent::__construct($this->translate($errorCode, $replace), $statusCode);
        $this->errorCode       = $errorCode;
        $this->statusCode      = $statusCode;
        $this->extraParameters = $extraParameters;
    }

    public function getErrorCode(): string
    {
        $arrayErrorCode = explode('.', $this->errorCode);

        return (string) last($arrayErrorCode);
    }

    public function getErrorMessage(): string
    {
        if ($this->errorCode == $this->getMessage()) {
            return '';
        }

        return $this->getMessage();
    }

    private function translate(string $errorCode, array $replace): string
    {
        try {
            return (string) __($errorCode, $replace);
        } catch (Throwable) {
            return '';
        }
    }

    private function getResponse(): array
    {
        $response = [
            'code'    => $this->getErrorCode(),
            'message' => $this->getErrorMessage(),
        ];

        if (! empty($this->extraParameters)) {
            $response = array_merge($response, $this->extraParameters);
        }

        return array_filter($response);
    }

    public function render(): JsonResponse
    {
        return response()->json($this->getResponse(), $this->statusCode);
    }
}
