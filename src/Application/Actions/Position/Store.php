<?php

declare(strict_types=1);

namespace App\Application\Actions\Position;

use Psr\Http\Message\ResponseInterface as Response;

abstract class Store extends \App\Application\Actions\Position\Action
{
    /**
     * @var \App\Domain\Position\Validation\Rule $validationRule
     */
    protected \App\Domain\Position\Validation\Rule $validationRule;

    /**
     * @var \Illuminate\Validation\Factory $validatorFactory
     */
    protected \Illuminate\Validation\Factory $validatorFactory;

    /**
     * @param \App\Infrastructure\Filesystem\Log\PositionActionLogger $logger
     * @param \Illuminate\Translation\Translator $translator
     * @param \App\Domain\PositionRepositoryInterface $positionRepository
     * @param \App\Domain\Position\Validation\Rule $validationRule
     * @param \Illuminate\Validation\Factory $validatorFactory
     */
    public function __construct(
        \App\Infrastructure\Filesystem\Log\PositionActionLogger $logger,
        \Illuminate\Translation\Translator $translator,
        \App\Domain\PositionRepositoryInterface $positionRepository,
        \App\Domain\Position\Validation\Rule $validationRule,
        \Illuminate\Validation\Factory $validatorFactory
    ) {
        parent::__construct($logger, $translator, $positionRepository);

        $this->validationRule = $validationRule;
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainRecordNotSavedException
     * @throws \App\Domain\DomainException\DomainException
     * @throws \JsonException
     */
    protected function action(): Response
    {
        $positionData = $this->getFormData();

        $this->validate($positionData);
        $position = $this->init($positionData);
        $this->save($position);

        return $this->sendResponse($position);
    }

    /**
     * Validate user data before save
     *
     * @param array $positionData
     * @param bool $ignoreCode
     * @return bool
     * @throws \App\Domain\DomainException\DomainRecordNotSavedException
     * @throws \JsonException
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    protected function validate(array $positionData, bool $ignoreCode = false): bool
    {
        try {
            $positionCode = $this->resolveArg('code');
        } catch (\Slim\Exception\HttpBadRequestException $exception) {
            $positionCode = $positionData['code'];
        }

        $validator = $this->validatorFactory->make(
            $positionData,
            $this->validationRule->getRules($positionCode, $ignoreCode),
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
     * Save user
     *
     * @throws \App\Domain\DomainException\DomainException
     */
    protected function save(\App\Domain\Position $position): void
    {
        try {
            $this->positionRepository->save($position);
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }
    }

    /**
     * Init user
     *
     * @param array $positionData
     * @return \App\Domain\Position
     */
    abstract protected function init(array $positionData): \App\Domain\Position;

    /**
     * Send response
     *
     * @param \App\Domain\Position $position
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \JsonException
     */
    abstract protected function sendResponse(\App\Domain\Position $position): Response;
}
