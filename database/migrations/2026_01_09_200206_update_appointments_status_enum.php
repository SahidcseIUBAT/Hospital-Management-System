<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE appointments 
            MODIFY status ENUM(
                'pending_payment',
                'booked',
                'checked_in',
                'in_progress',
                'completed',
                'cancelled'
            ) NOT NULL DEFAULT 'pending_payment'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE appointments 
            MODIFY status ENUM(
                'booked',
                'checked_in',
                'in_progress',
                'completed',
                'cancelled'
            ) NOT NULL DEFAULT 'booked'
        ");
    }
};
