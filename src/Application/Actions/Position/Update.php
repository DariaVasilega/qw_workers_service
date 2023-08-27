<?php

declare(strict_types=1);

namespace App\Application\Actions\Position;

use Psr\Http\Message\ResponseInterface as Response;

class Update extends \App\Application\Actions\Position\Store
{
    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $positionData = $this->getFormData();
        $position = $this->init($positionData);

        $this->validate($positionData, true);

        $this->save($position->fill($positionData));

        return $this->sendResponse($position);
    }

    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainException
     */
    protected function init(array $positionData): \App\Domain\Position
    {
        try {
            $position = $this->positionRepository->get($this->resolveArg('code'));
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }

        return $position;
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    protected function validate(array $positionData, bool $ignoreCode = false): bool
    {
        try {
            $positionCode = $this->resolveArg('code');
        } catch (\Slim\Exception\HttpBadRequestException $exception) {
            $positionCode = $positionData['code'];
        }

        $allValidationRules = $this->validationRule->getRules($positionCode, $ignoreCode);
        $suitableRules = array_intersect_key($allValidationRules, $positionData);

        $validator = $this->validatorFactory->make(
            $positionData,
            $suitableRules,
            $this->validationRule->getMessages()
        );

        if ($validator->fails()) {
            throw new \App\Domain\DomainException\DomainRecordNotSavedException(
                json_encode($validator->getMessageBag(), JSON_THROW_ON_ERROR)
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function sendResponse(\App\Domain\Position $position): Response
    {
        return $this->respondWithData(['message' => $this->translator->get('action.update.success')]);
    }
}
