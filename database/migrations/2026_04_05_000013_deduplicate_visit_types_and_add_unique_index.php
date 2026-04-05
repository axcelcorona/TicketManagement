<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicates = DB::table('visit_types')
            ->select('name')
            ->whereNotNull('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('name');

        foreach ($duplicates as $name) {
            $visitTypes = DB::table('visit_types')
                ->where('name', $name)
                ->orderBy('id')
                ->get(['id']);

            $canonicalId = $visitTypes->first()->id;
            $duplicateIds = $visitTypes->skip(1)->pluck('id');

            if ($duplicateIds->isEmpty()) {
                continue;
            }

            DB::table('tickets')
                ->whereIn('visit_type_id', $duplicateIds)
                ->update(['visit_type_id' => $canonicalId]);

            DB::table('visit_types')
                ->whereIn('id', $duplicateIds)
                ->delete();
        }

        Schema::table('visit_types', function (Blueprint $table): void {
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('visit_types', function (Blueprint $table): void {
            $table->dropUnique(['name']);
        });
    }
};
