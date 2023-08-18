<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * @property int $id
 * @property string $email
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $dob
 */
class User extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @inheritDoc
     */
    public $timestamps = false;

    /**
     * @inheritDoc
     */
    protected $table = 'user';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'email',
        'firstname',
        'middlename',
        'lastname',
        'dob',
    ];
}
