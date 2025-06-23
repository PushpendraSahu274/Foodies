<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\Command;

class WipeDatabase extends Command
{
    protected $signature = 'db:wipe-preserve-schema';
    protected $description = 'Delete all data without dropping tables';



public function handle()
{
    Schema::disableForeignKeyConstraints();

    // Get all table names from the schema
    $tables = DB::select('SHOW TABLES');
    $dbName = env('DB_DATABASE');
    $key = "Tables_in_{$dbName}";

    foreach ($tables as $table) {
        $tableName = $table->$key;

        if ($tableName !== 'migrations') {
            DB::table($tableName)->truncate();
        }
    }

    Schema::enableForeignKeyConstraints();

    $this->info('✅ All tables truncated successfully (no schema dropped).');
}

}