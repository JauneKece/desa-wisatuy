<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MigrateUsersToDb2Format extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-users-db2 
                            {--dry-run : Preview changes without saving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users data: akitf with is_active, and update role enum values (manager→owner, staff→bendahara, customer→pelanggan)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        $this->info('Starting migration of users to DB2 format...');
        $this->info($dryRun ? '[DRY RUN MODE - No changes will be saved]' : '');

        $users = User::all();

        if ($users->isEmpty()) {
            $this->info('✓ No users found!');
            return 0;
        }

        $this->info("Found {$users->count()} users to check.\n");

        $updated = 0;
        $failed = 0;

        foreach ($users as $user) {
            try {
                $changes = false;
                $oldRole = $user->role ?? 'N/A';
                $oldAkitf = $user->akitf ?? 'N/A';

                // Sync akitf dengan is_active
                if (is_null($user->akitf) || ($user->akitf != (int)$user->is_active)) {
                    $newAkitf = (int)$user->is_active;
                    $changes = true;
                } else {
                    $newAkitf = $user->akitf;
                }

                if ($changes) {
                    $this->line("User ID #{$user->id} ({$user->name}):");
                    $this->line("  role: {$oldRole} (tetap)");
                    $this->line("  akitf: {$oldAkitf} → {$newAkitf}");

                    if (!$dryRun) {
                        $user->akitf = $newAkitf;
                        $user->save();
                        $this->line("  ✓ Saved\n");
                    } else {
                        $this->line("  [PREVIEW ONLY - Not saved]\n");
                    }

                    $updated++;
                }
            } catch (\Exception $e) {
                $this->error("  ✗ Failed to migrate user {$user->id}: {$e->getMessage()}\n");
                $failed++;
            }
        }

        $this->info("=== Migration Summary ===");
        $this->info("Updated: {$updated}");
        $this->info("Failed: {$failed}");

        if ($dryRun) {
            $this->info("\n[DRY RUN] To apply these changes, run without --dry-run flag:");
            $this->info("  php artisan db:migrate-users-db2");
        }

        return 0;
    }
}

