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
        $roleUserTable = config('fortress.role_user_table');
        $permissionsTable = config('fortress.permissions_table');
        $permissionUserTable = config('fortress.permission_user_table');
        $permissionRoleTable = config('fortress.permission_role_table');
        $organizationsTable = config('fortress.organizations_table');
        $organizationUserTable = config('fortress.organization_user_table');
        $organizationUserRoleTable = config('fortress.organization_user_role_table');
        $organizationUserPermissionTable = config('fortress.organization_user_permission_table');

        $this->line('');
        $this->info("Tables: $rolesTable, $roleUserTable, $permissionsTable, $permissionRoleTable, $organizationUserRoleTable, $organizationUserPermissionTable, $organizationUserTable, $organizationsTable");

        $message = "A migration that creates '$rolesTable', '$roleUserTable', '$permissionsTable', '$permissionRoleTable', '$permissionUserTable', '$organizationUserTable', '$organizationUserRoleTable', '$organizationUserPermissionTable', '$organizationsTable'" . " tables will be created in database/migrations directory";

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

        $userForeignKey = config('fortress.user_foreign_key');
        $rolesTable = config('fortress.roles_table');
        $roleUserTable = config('fortress.role_user_table');
        $roleForeignKey = config('fortress.role_foreign_key');
        $permissionsTable = config('fortress.permissions_table');
        $permissionUserTable = config('fortress.permission_user_table');
        $permissionRoleTable = config('fortress.permission_role_table');
        $permissionForeignKey = config('fortress.permission_foreign_key');
        $organizationsTable = config('fortress.organizations_table');
        $organizationUserTable = config('fortress.organization_user_table');
        $organizationForeignKey = config('fortress.organization_foreign_key');
        $organizationUserRoleTable = config('fortress.organization_user_role_table');
        $organizationUserForeignKey = config('fortress.organization_user_foreign_key');
        $organizationUserPermissionTable = config('fortress.organization_user_permission_table');

        $migrationFile = base_path("/database/migrations") . "/" . date('Y_m_d_His') . "_create_fortress_setup_tables.php";



        $userModelName = Config::get('auth.providers.users.model');
        $userModel = new $userModelName();
        $usersTable = $userModel->getTable();
        $userKeyName = $userModel->getKeyName();

        $data = compact('rolesTable', 'roleUserTable', 'permissionsTable', 'permissionRoleTable', 'usersTable', 'userKeyName', 'roleForeignKey', 'permissionUserTable', 'permissionForeignKey', 'organizationsTable', 'organizationUserTable', 'permissionForeignKey', 'organizationForeignKey', 'organizationUserRoleTable', 'organizationUserForeignKey', 'organizationUserPermissionTable', 'userForeignKey');

//        dd($this->laravel->view->make('fortress::generators.migration'));

        $output = $this->laravel->view->make('fortress::generators.migration')->with($data)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
