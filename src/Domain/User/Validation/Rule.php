<?php

declare(strict_types=1);

namespace App\Domain\User\Validation;

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
     */
    public function getRules(int $userId = 0): array
    {
        return [
            'email' => [
                'required',
                'email',
                "unique:user,email,$userId",
            ],
            'firstname' => [
                'required',
                'max:63',
            ],
            'middlename' => [
                'required',
                'max:63',
            ],
            'lastname' => [
                'required',
                'max:63',
            ],
            'dob' => [
                'required',
                'date_format:Y-m-d',
                'before:today',
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): array
    {
        return [
            'email.required' => $this->translator->get('validation.required'),
            'email.email' => $this->translator->get('validation.format', ['format' => 'email@example.com']),
            'email.unique' => $this->translator->get('validation.unique'),
            'firstname.required' => $this->translator->get('validation.required'),
            'firstname.max' => $this->translator->get('validation.max.string', ['max' => 63]),
            'middlename.required' => $this->translator->get('validation.required'),
            'middlename.max' => $this->translator->get('validation.max.string', ['max' => 63]),
            'lastname.required' => $this->translator->get('validation.required'),
            'lastname.max' => $this->translator->get('validation.max.string', ['max' => 63]),
            'dob.required' => $this->translator->get('validation.required'),
            'dob.date_format' => $this->translator->get('validation.format', ['format' => 'Y-m-d']),
            'dob.before' => $this->translator->get('validation.before', ['before' => date('Y-m-d')]),
        ];
    }
}
