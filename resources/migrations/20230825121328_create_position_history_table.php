<?php

declare(strict_types=1);

use App\Infrastructure\Database\Migration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * @SuppressWarnings(PHPMD.ShortMethodNames)
 */
final class CreatePositionHistoryTable extends Migration
{
    public function up(): void
    {
        $this->schema->create('position_history', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('position_code', 63);
            $table->float('salary');
            $table->dateTime('from_date');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('position_code')
                ->references('code')
                ->on('position')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        $this->schema->drop('position_history');
    }
}
