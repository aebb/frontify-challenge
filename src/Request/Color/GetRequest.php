<?php

namespace Frontify\ColorApi\Request\Color;

use Frontify\ColorApi\Request\Request;
use Frontify\ColorApi\Utils\AppException;
use Frontify\ColorApi\Utils\ErrorCode;
use Frontify\ColorApi\Utils\HttpResponse;
use Sunrise\Http\ServerRequest\ServerRequest;

class GetRequest extends Request
{
    public const ERROR_EMPTY = 'id must be present';
    public const ERROR_NOT_A_NUMBER = 'id must be an integer';

    protected ?string $id;

    public function __construct(ServerRequest $request)
    {
        parent::__construct($request);
        $array = explode('/', $request->getUri()->getPath());
        $this->id = end($array) ?? null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @throws AppException
     */
    public function validate(): bool
    {
        if (empty($this->id)) {
            throw new AppException(
                self::ERROR_EMPTY,
                ErrorCode::ERROR_CODE_GET_COLORS,
                null,
                HttpResponse::HTTP_BAD_REQUEST
            );
        }

        if (!filter_var($this->id, FILTER_VALIDATE_INT)) {
            throw new AppException(
                self::ERROR_NOT_A_NUMBER,
                ErrorCode::ERROR_CODE_GET_COLORS,
                null,
                HttpResponse::HTTP_BAD_REQUEST
            );
        }

        return true;
    }
}
