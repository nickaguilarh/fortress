<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTables extends Migration
{
    protected $rolesTable, $roleUserTable, $permissionsTable, $permissionRoleTable, $organizationsTable, $organizationUserTable, $organizationForeignKey, $userForeignKey, $usersTable, $organizationUserRoleTable, $organizationUserPermissionTable, $organizationUserForeignKey, $roleForeignKey, $permissionForeignKey, $permissionUserTable;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->usersTable = config('fortress.users_table');
        $this->userForeignKey = config('fortress.user_foreign_key');
        $this->rolesTable = config('fortress.roles_table');
        $this->roleUserTable = config('fortress.role_user_table');
        $this->roleForeignKey = config('fortress.role_foreign_key');
        $this->permissionsTable = config('fortress.permissions_table');
        $this->permissionUserTable = config('fortress.permission_user_table');
        $this->permissionRoleTable = config('fortress.permission_role_table');
        $this->permissionForeignKey = config('fortress.permission_foreign_key');
        $this->organizationsTable = config('fortress.organizations_table');
        $this->organizationUserTable = config('fortress.organization_user_table');
        $this->organizationForeignKey = config('fortress.organization_foreign_key');
        $this->organizationUserRoleTable = config('fortress.organization_user_role_table');
        $this->organizationUserForeignKey = config('fortress.organization_user_foreign_key');
        $this->organizationUserPermissionTable = config('fortress.organization_user_permission_table');


        DB::beginTransaction();

        // Create table for storing roles
        Schema::create($this->rolesTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->morphs('roleable');
            $table->timestamps();
        });
        // Create table for storing permissions
        Schema::create($this->permissionsTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->morphs('permissionable');
            $table->timestamps();
        });
        //Create table for storing permission_role
        Schema::create($this->permissionRoleTable, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer($this->permissionForeignKey)->unsigned();
            $table->foreign($this->permissionForeignKey)->references('id')->on($this->permissionsTable)->onUpdate('cascade')->onDelete('cascade');
            $table->integer($this->roleForeignKey)->unsigned();
            $table->foreign($this->roleForeignKey)->references('id')->on($this->rolesTable)->onUpdate('cascade')->onDelete('cascade');
        });
        //Create table for storing role_user
        Schema::create($this->roleUserTable, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer($this->roleForeignKey)->unsigned();
            $table->foreign($this->roleForeignKey)->references('id')->on($this->rolesTable)->onUpdate('cascade')->onDelete('cascade');
            $table->integer($this->userForeignKey)->unsigned();
            $table->foreign($this->userForeignKey)->references('id')->on($this->usersTable)->onUpdate('cascade')->onDelete('cascade');
        });
        //Create table for storing permission_user
        Schema::create($this->permissionUserTable, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer($this->permissionForeignKey)->unsigned();
            $table->foreign($this->permissionForeignKey)->references('id')->on($this->permissionsTable)->onUpdate('cascade')->onDelete('cascade');
            $table->integer($this->userForeignKey)->unsigned();
            $table->foreign($this->userForeignKey)->references('id')->on($this->usersTable)->onUpdate('cascade')->onDelete('cascade');
        });
        // Create table for storing organization_user
        Schema::create($this->organizationUserTable, function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer($this->userForeignKey)->unsigned();
            $table->foreign($this->userForeignKey)->references('id')->on($this->usersTable)->onUpdate('cascade')->onDelete('cascade');
            $table->integer($this->organizationForeignKey)->unsigned();
            $table->foreign($this->organizationForeignKey)->references('id')->on($this->organizationsTable)->onUpdate('cascade')->onDelete('cascade');
        });
        // Create table for storing organization_user_role
        Schema::create($this->organizationUserRoleTable, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer($this->organizationUserForeignKey)->unsigned();
            $table->foreign($this->organizationUserForeignKey)->references('id')->on($this->organizationUserTable)->onUpdate('cascade')->onDelete('cascade');
            $table->integer($this->roleForeignKey)->unsigned();
            $table->foreign($this->roleForeignKey)->references('id')->on($this->rolesTable)->onUpdate('cascade')->onDelete('cascade');
        });
        // Create table for storing organization_user_permission
        Schema::create($this->organizationUserPermissionTable, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer($this->organizationUserForeignKey)->unsigned();
            $table->foreign($this->organizationUserForeignKey)->references('id')->on($this->organizationUserTable);
            $table->integer($this->permissionForeignKey)->unsigned();
            $table->foreign($this->permissionForeignKey)->references('id')->on($this->permissionsTable)->onUpdate('cascade')->onDelete('cascade');
        });

        DB::commit();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        $this->usersTable = config('fortress.users_table');
        $this->userForeignKey = config('fortress.user_foreign_key');
        $this->rolesTable = config('fortress.roles_table');
        $this->roleUserTable = config('fortress.role_user_table');
        $this->roleForeignKey = config('fortress.role_foreign_key');
        $this->permissionsTable = config('fortress.permissions_table');
        $this->permissionUserTable = config('fortress.permission_user_table');
        $this->permissionRoleTable = config('fortress.permission_role_table');
        $this->permissionForeignKey = config('fortress.permission_foreign_key');
        $this->organizationsTable = config('fortress.organizations_table');
        $this->organizationUserTable = config('fortress.organization_user_table');
        $this->organizationForeignKey = config('fortress.organization_foreign_key');
        $this->organizationUserRoleTable = config('fortress.organization_user_role_table');
        $this->organizationUserForeignKey = config('fortress.organization_user_foreign_key');
        $this->organizationUserPermissionTable = config('fortress.organization_user_permission_table');

        DB::beginTransaction();
        Schema::drop($this->organizationUserPermissionTable);
        Schema::drop($this->organizationUserRoleTable);
        Schema::drop($this->organizationUserTable);
        Schema::drop($this->permissionUserTable);
        Schema::drop($this->roleUserTable);
        Schema::drop($this->permissionRoleTable);
        Schema::drop($this->permissionsTable);
        Schema::drop($this->rolesTable);
        DB::commit();
    }
}
