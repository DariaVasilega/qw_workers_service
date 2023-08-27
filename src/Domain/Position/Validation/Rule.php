<?php

declare(strict_types=1);

namespace App\Domain\Position\Validation;

class Rule implements \App\Application\ValidationRuleInterface
{
    /**
     * @var \Illuminate\Translation\Translator $translator
     */
    private \Illuminate\Translation\Translator $translator;

    /**
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        \Illuminate\Translation\Translator $translator
    ) {
        $this->translator = $translator;
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getRules(string $positionCode = '', bool $ignoreCode = false): array
    {
        $uniqRule = \Illuminate\Validation\Rule::unique('position', 'code');

        return [
            'code' => [
                'required',
                'max:63',
                'regex:/^[A-z0-9_-]*$/',
                $ignoreCode ? $uniqRule->ignore($positionCode, 'code') : $uniqRule,
            ],
            'label' => [
                'required',
                'max:255',
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): array
    {
        return [
            'code.required' => $this->translator->get('validation.required'),
            'code.max' => $this->translator->get('validation.max.string'),
            'code.regex' => $this->translator->get('role.validation.code.regex'),
            'code.unique' => $this->translator->get('validation.unique'),
            'label.required' => $this->translator->get('validation.required'),
            'label.max' => $this->translator->get('validation.max.string'),
        ];
    }
}
