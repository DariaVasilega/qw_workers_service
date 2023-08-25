<?php

declare(strict_types=1);

use App\Infrastructure\Database\Migration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * @SuppressWarnings(PHPMD.ShortMethodNames)
 */
final class AddPositionIdColumnToUserTable extends Migration
{
    public function up(): void
    {
        $this->schema->table('user', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->unsignedInteger('current_position_id')->nullable();

            $table
                ->foreign('current_position_id')
                ->references('id')
                ->on('position_history')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        $this->schema->table('user', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropForeign(['current_position_id']);
        });
        $this->schema->dropColumns('user', 'current_position_id');
    }
}
