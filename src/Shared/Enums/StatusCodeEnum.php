<?php

namespace Src\Shared\Enums;

enum StatusCodeEnum: int
{
    case OK = 200;
    /**
     * La solicitud se realizó correctamente y, como resultado, se creó un nuevo recurso.
     */
    case CREATED = 201;

    /**
     * No hay contenido para enviar para esta solicitud pero se realizo correctamente.
     */
    case NO_CONTENT = 204;

    case HTTP_MULTIPLE_CHOICES = 300;

    /**
     * No se procesa la solicitud debido a que hay algun error del cliente (sintaxis, formato, etc).
     */
    case BAD_REQUEST = 400;

    /**
     * No se procesa la solicitud ya que no se encuentra autenticado.
     */
    case UNAUTHORIZED = 401;

    /**
     * El cliente no posee los permisos para realizar esta acción.
     */
    case FORBIDDEN = 403;

    /**
     * No se encuentra el recurso solicitado.
     */
    case NOT_FOUND = 404;

    /**
     * Error de la lógica de negocio.
     */
    case CONFLICT = 409;

    /**
     * No se puede procesar la solicitud debido a fallas en validaciones.
     */
    case UNPROCESSABLE_CONTENT = 422;

    case INTERNAL_SERVER_ERROR = 500;

}
