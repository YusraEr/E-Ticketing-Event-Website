
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'ticket_code')) {
                $table->string('ticket_code')->after('id');
            }
            if (!Schema::hasColumn('tickets', 'is_used')) {
                $table->boolean('is_used')->default(false)->after('price');
            }
            // Add any other missing columns
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['ticket_code', 'is_used']);
            // Drop any other added columns
        });
    }
};
