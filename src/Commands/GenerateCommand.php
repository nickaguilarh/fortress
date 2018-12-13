<?php

namespace NickAguilarH\Fortress;

use Illuminate\Console\Command;
use NickAguilarH\Fortress\Models\Role;

class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fortress:generate {input} {--M|mode=role} {--G|generate=crud}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input = $this->argument('input');
        $mode = $this->option('mode');
        $generate = $this->option('generate');

        $display = $this->ask('Insert a display name for ' . $input);
        $description = $this->ask('Insert a description for ' . $input);

        if ($mode == 'role') {
            try {
                self::createRole($input, $display, $description);
            } catch (\Exception $exception) {
                $this->error('We couldn\'t create the role.');
                $this->line('');
                $this->error($exception->getMessage());
                if (env('APP_DEBUG')) {
                    $this->line('');
                    $this->error($exception->getTraceAsString());
                }
            }
        } else if ($mode == 'perm') {
            try {
                if (strpos($generate, 'c') !== false) {
                    self::createPerm('create-' . strtolower($input), 'Create ' . $display, 'Create: ' . $description);
                }
                if (strpos($generate, 'r') !== false) {
                    self::createPerm('view-' . strtolower($input), 'View ' . $display, 'Create: ' . $description);
                }
                if (strpos($generate, 'u') !== false) {
                    self::createPerm('update-' . strtolower($input), 'Update ' . $display, 'Create: ' . $description);
                }
                if (strpos($generate, 'd') !== false) {
                    self::createPerm('delete-' . strtolower($input), 'Delete ' . $display, 'Create: ' . $description);
                }
            } catch (\Exception $exception) {
                $this->error('We couldn\'t create the perms.');
                $this->line('');
                $this->error($exception->getMessage());
                if (env('APP_DEBUG')) {
                    $this->line('');
                    $this->error($exception->getTraceAsString());
                }
            }
        }


    }

    private function createRole($role, $display = null, $description = null)
    {
        $r = new Role();
        $r->name = strtolower($role);
        $r->display_name = $display;
        $r->description = $description;
        $r->save();

        $this->info("Role $role has been created.");
    }

    private function createPerm($perm, $display = null, $description = null)
    {
        $p = new Permission();
        $p->name = strtolower($perm);
        $p->display_name = $display;
        $p->description = $description;
        $p->save();

        $this->info("Permission $perm has been created.");
    }
}
