<?php

declare(strict_types=1);

use App\Infrastructure\Database\Migration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * @SuppressWarnings(PHPMD.ShortMethodNames)
 */
final class CreateUserTable extends Migration
{
    public function up(): void
    {
        $this->schema->create('user', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('firstname', 63);
            $table->string('middlename', 63);
            $table->string('lastname', 63);
            $table->dateTime('dob');
        });
    }

    public function down(): void
    {
        $this->schema->drop('user');
    }
}
