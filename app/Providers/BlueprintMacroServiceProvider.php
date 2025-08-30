<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class BlueprintMacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Add columns
        Blueprint::macro('activitiesBy', function (?bool $foreignKeys = false) {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->unsignedBigInteger('created_by')->nullable()->index();
            $this->unsignedBigInteger('updated_by')->nullable()->index();
            $this->unsignedBigInteger('deleted_by')->nullable()->index();

            if ($foreignKeys) {
                // If you actually want FKs; optional because 3 FKs can be heavy
                $this->foreign('created_by')->references('id')->on('users')->nullOnDelete();
                $this->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
                $this->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
            }
        });

        // Drop columns (for down() migrations)
        Blueprint::macro('dropActivitiesBy', function () {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            // drop FKs if they exist (safe to try)
            foreach (['created_by', 'updated_by', 'deleted_by'] as $col) {
                $fk = $this->getTable().'_'.$col.'_foreign';
                try { $this->dropForeign($fk); } catch (\Throwable $e) {}
            }
            $this->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });
    }
}
