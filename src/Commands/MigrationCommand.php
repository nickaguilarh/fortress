<?php

namespace NickAguilarH\Fortress;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fortress:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Fortress specifications.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the console command for Laravel 5.5+.
     *
     * @return void
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('fortress', substr(__DIR__, 0, -8) . 'Views');

        $rolesTable = config('fortress.roles_table');
        $permissionsTable = config('fortress.permissions_table');
        $permissionRoleTable = config('fortress.permission_role_table');
        $personaTable = config('fortress.persona_table');
        $personaRoleTable = config('fortress.persona_role_table');
        $personaPermissionTable = config('fortress.persona_permission_table');

        $this->line('');
        $this->info("Tables: $rolesTable, $permissionsTable, $permissionRoleTable, $personaTable, $personaRoleTable, $personaPermissionTable");

        $message = "A migration that creates '$rolesTable', '$permissionsTable', '$permissionRoleTable', '$personaTable', '$personaRoleTable', '$personaPermissionTable'" . " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration()) {

                $this->info("Migration successfully created!");
            } else {
                $this->error(
                    "Couldn't create migration.\n Check the write permissions" .
                    " within the database/migrations directory."
                );
            }

            $this->line('');

        }
    }

    /**
     * Create the migration.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function createMigration()
    {
        // Tables
        $rolesTable = config('fortress.roles_table');
        $permissionsTable = config('fortress.permissions_table');
        $permissionRoleTable = config('fortress.permission_role_table');
        $personaTable = config('fortress.persona_table');
        $personaRoleTable = config('fortress.persona_role_table');
        $personaPermissionTable = config('fortress.persona_permission_table');

        // Keys
        $userForeignKey = config('fortress.user_foreign_key');
        $roleForeignKey = config('fortress.role_foreign_key');
        $permissionForeignKey = config('fortress.permission_foreign_key');
        $personaForeignKey = config('fortress.persona_foreign_key');


        $personableColumn = config('fortress.personable_column');

        $migrationFile = base_path("/database/migrations") . "/" . date('Y_m_d_His') . "_create_fortress_setup_tables.php";


        $userModelName = Config::get('auth.providers.users.model');
        $userModel = new $userModelName();
        $usersTable = $userModel->getTable();
        $userKeyName = $userModel->getKeyName();

        $data = compact('rolesTable', 'permissionsTable', 'permissionRoleTable', 'usersTable', 'userKeyName', 'roleForeignKey', 'permissionForeignKey', 'personaTable', 'personaRoleTable', 'personaForeignKey', 'personaPermissionTable', 'userForeignKey','personableColumn');

        $output = $this->laravel->view->make('fortress::Generators.migration')->with($data)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
