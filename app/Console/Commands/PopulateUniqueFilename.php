<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PopulateUniqueFilename extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-unique-filename';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the unique_filename column in the tutorials table with UUIDs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //transaksi database untuk memastikan integritas data
        DB::beginTransaction();

        try {
            //semua ID dari tabel tutorials yang memiliki unique_filename null
            $tutorialIds = DB::table('tutorials')
                ->whereNull('unique_filename')
                ->pluck('id');

            //loop melalui setiap ID dan update unique_filename dengan UUID
            foreach ($tutorialIds as $id) {
                DB::table('tutorials')
                    ->where('id', $id)
                    ->update(['unique_filename' => Str::uuid()]);
            }

            //commit transaksi jika semua update berhasil
            DB::commit();

            $this->info('Successfully populated unique_filename column for ' . count($tutorialIds) . ' tutorials.');
        } catch (\Exception $e) {
            //rollback transaksi jika terjadi kesalahan
            DB::rollback();

            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
