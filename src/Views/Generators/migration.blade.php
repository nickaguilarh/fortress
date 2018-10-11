<?php echo '<?php' ?>


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFortressSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        // Create table for storing roles
        Schema::create('{{$rolesTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('{{$organizationForeignKey}}')->unsigned()->nullable();
            $table->foreign('{{$organizationForeignKey}}')->references('id')->on('{{$organizationsTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        // Create table for storing permissions
        Schema::create('{{$permissionsTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('{{$organizationForeignKey}}')->unsigned()->nullable();
            $table->foreign('{{$organizationForeignKey}}')->references('id')->on('{{$organizationsTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        //Create table for storing permission_role
        Schema::create('{{$permissionRoleTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$permissionForeignKey}}')->unsigned();
            $table->foreign('{{$permissionForeignKey}}')->references('id')->on('{{$permissionsTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('{{$roleForeignKey}}')->unsigned();
            $table->foreign('{{$roleForeignKey}}')->references('id')->on('{{$rolesTable}}')->onUpdate('cascade')->onDelete('cascade');
        });
        //Create table for storing role_user
        Schema::create('{{$roleUserTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$roleForeignKey}}')->unsigned();
            $table->foreign('{{$roleForeignKey}}')->references('id')->on('{{$rolesTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('{{$userForeignKey}}')->unsigned();
            $table->foreign('{{$userForeignKey}}')->references('id')->on('{{$usersTable}}')->onUpdate('cascade')->onDelete('cascade');
        });
        //Create table for storing permission_user
        Schema::create('{{$permissionUserTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$permissionForeignKey}}')->unsigned();
            $table->foreign('{{$permissionForeignKey}}')->references('id')->on('{{$permissionsTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('{{$userForeignKey}}')->unsigned();
            $table->foreign('{{$userForeignKey}}')->references('id')->on('{{$usersTable}}')->onUpdate('cascade')->onDelete('cascade');
        });
        // Create table for storing organization_user
        Schema::create('{{$organizationUserTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$userForeignKey}}')->unsigned();
            $table->foreign('{{$userForeignKey}}')->references('id')->on('{{$usersTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('{{$organizationForeignKey}}')->unsigned();
            $table->foreign('{{$organizationForeignKey}}')->references('id')->on('{{$organizationsTable}}')->onUpdate('cascade')->onDelete('cascade');
        });
        // Create table for storing organization_user_role
        Schema::create('{{$organizationUserRoleTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$organizationUserForeignKey}}')->unsigned();
            $table->foreign('{{$organizationUserForeignKey}}')->references('id')->on('{{$organizationUserTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('{{$roleForeignKey}}')->unsigned();
            $table->foreign('{{$roleForeignKey}}')->references('id')->on('{{$rolesTable}}')->onUpdate('cascade')->onDelete('cascade');
        });
        // Create table for storing organization_user_permission
        Schema::create('{{$organizationUserPermissionTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$organizationUserForeignKey}}')->unsigned();
            $table->foreign('{{$organizationUserForeignKey}}')->references('id')->on('{{$organizationUserTable}}');
            $table->integer('{{$permissionForeignKey}}')->unsigned();
            $table->foreign('{{$permissionForeignKey}}')->references('id')->on('{{$permissionsTable}}')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('{{$organizationUserPermissionTable}}');
        Schema::drop('{{$organizationUserRoleTable}}');
        Schema::drop('{{$organizationUserTable}}');
        Schema::drop('{{$permissionUserTable}}');
        Schema::drop('{{$roleUserTable}}');
        Schema::drop('{{$permissionRoleTable}}');
        Schema::drop('{{$permissionsTable}}');
        Schema::drop('{{$rolesTable}}');
    }
}
