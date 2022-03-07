<?php

namespace Frontify\ColorApi\Service;

use Frontify\ColorApi\Entity\Color;
use Frontify\ColorApi\Request\Color\DeleteRequest;
use Frontify\ColorApi\Request\Color\GetRequest;
use Frontify\ColorApi\Repository\ColorRepository;
use Frontify\ColorApi\Request\Color\PostRequest;
use Frontify\ColorApi\Utils\AppException;
use Frontify\ColorApi\Utils\ErrorCode;
use Frontify\ColorApi\Utils\HttpResponse;
use Frontify\ColorApi\Utils\Logger;

class ColorService extends Service
{
    protected ColorRepository $repository;

    public function __construct(Logger $logger, ColorRepository $repository)
    {
        parent::__construct($logger);
        $this->repository = $repository;
    }

    /**
     * @throws AppException
     */
    public function get(GetRequest $request): Color
    {
        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_STARTED . $request->getRequest()->getUri()->getPath());

        $color = $this->repository->getColorById($request->getId());

        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_QUERY . $color);

        if (!$color) {
            throw new AppException(
                ErrorCode::COLOR_NOT_FOUND,
                ErrorCode::ERROR_CODE_GET_COLORS,
                null,
                HttpResponse::HTTP_NOT_FOUND
            );
        }

        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_FINISH . $request->getRequest()->getUri()->getPath());
        return $color;
    }

    /**
     * @throws AppException
     */
    public function create(PostRequest $request): Color
    {
        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_STARTED . $request->getRequest()->getUri()->getPath());

        $color = $this->repository->getColorByName($request->getName());

        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_QUERY . $color);
        if ($color) {
            throw new AppException(
                ErrorCode::DUPLICATE_COLOR_NAME,
                ErrorCode::ERROR_CODE_CREATE_COLORS,
                null,
                HttpResponse::HTTP_CONFLICT
            );
        }

        $newColor = new Color(['name' => $request->getName(), 'hexCode' => $request->getHexCode()]);
        $newColor = $this->repository->create($newColor);

        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_QUERY . $newColor);
        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_FINISH . $newColor);

        return $newColor;
    }

    /**
     * @throws AppException
     */
    public function delete(DeleteRequest $request): Color
    {
        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_STARTED . $request->getRequest()->getUri()->getPath());

        $color = $this->repository->getColorById($request->getId());

        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_QUERY . $color);

        if (!$color) {
            throw new AppException(
                ErrorCode::COLOR_NOT_FOUND,
                ErrorCode::ERROR_CODE_DELETE_COLORS,
                null,
                HttpResponse::HTTP_NOT_FOUND
            );
        }

        $color = $this->repository->delete($color);

        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_QUERY . $color);
        $this->logger->log(Logger::LOGGER_INFO, Service::LOG_FINISH . $color);

        return $color;
    }
}
