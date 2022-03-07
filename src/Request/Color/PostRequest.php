<?php

namespace Frontify\ColorApi\Request\Color;

use Frontify\ColorApi\Request\Request;
use Frontify\ColorApi\Utils\AppException;
use Frontify\ColorApi\Utils\ErrorCode;
use Frontify\ColorApi\Utils\HttpResponse;
use Sunrise\Http\ServerRequest\ServerRequest;

class PostRequest extends Request
{
    public const ERROR_EMPTY_NAME = 'name must be present';
    public const ERROR_EMPTY_HEX_CODE = 'hexCode must be present';
    public const ERROR_OUT_OF_BOUNDS = 'name must be 0-255 chars long';
    public const ERROR_HEX_CODE_PATTERN = 'invalid hexCode pattern';
    public const LOWER_BOUND = 0;
    public const UPPER_BOUND = 255;
    public const HEX_COLOR_REGEX = '/#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})/';

    protected ?string $name;

    protected ?string $hexCode;

    public function __construct(ServerRequest $request)
    {
        parent::__construct($request);
        $body = (array) json_decode($request->getBody()->getContents()) ?? [];
        $this->name     = $body['name']    ?? null;
        $this->hexCode  = $body['hexCode'] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHexCode(): string
    {
        return $this->hexCode;
    }

    /**
     * @throws AppException
     */
    public function validate(): bool
    {
        return $this->validateName() && $this->validateHexCode();
    }

    /**
     * @throws AppException
     */
    private function validateName(): bool
    {
        if (empty($this->name)) {
            throw new AppException(
                self::ERROR_EMPTY_NAME,
                ErrorCode::ERROR_CODE_CREATE_COLORS,
                null,
                HttpResponse::HTTP_BAD_REQUEST
            );
        }

        $size = strlen($this->name);
        if ($size <= self::LOWER_BOUND || $size > self::UPPER_BOUND) {
            throw new AppException(
                self::ERROR_OUT_OF_BOUNDS,
                ErrorCode::ERROR_CODE_CREATE_COLORS,
                null,
                HttpResponse::HTTP_BAD_REQUEST
            );
        }

        return true;
    }

    /**
     * @throws AppException
     */
    public function validateHexCode(): bool
    {
        if (empty($this->hexCode)) {
            throw new AppException(
                self::ERROR_EMPTY_HEX_CODE,
                ErrorCode::ERROR_CODE_CREATE_COLORS,
                null,
                HttpResponse::HTTP_BAD_REQUEST
            );
        }

        if (!preg_match(self::HEX_COLOR_REGEX, $this->hexCode)) {
            throw new AppException(
                self::ERROR_HEX_CODE_PATTERN,
                ErrorCode::ERROR_CODE_CREATE_COLORS,
                null,
                HttpResponse::HTTP_BAD_REQUEST
            );
        }

        return true;
    }
}
