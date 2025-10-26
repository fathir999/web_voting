<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('candidates', function (Blueprint $table) {
        if (!Schema::hasColumn('candidates', 'deleted_at')) {
            $table->softDeletes(); // kolom deleted_at
        }
    });
}


    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
