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
            $table->timestamps();
        });
        // Create table for storing permissions
        Schema::create('{{$permissionsTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
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
        // Create table for storing the persona
        if (!Schema::hasTable('{{$personaTable}}')) {
            Schema::create('{{$personaTable}}', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('{{$userForeignKey}}')->unsigned();
                $table->foreign('{{$userForeignKey}}')->references('id')->on('{{$usersTable}}')->onUpdate('cascade')->onDelete('cascade');
                $table->morphs('{{$personaTable}}');
            });
        };
        // Create table for storing persona_role
        Schema::create('{{$personaRoleTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$personaForeignKey}}')->unsigned();
            $table->foreign('{{$personaForeignKey}}')->references('id')->on('{{$personaTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('{{$roleForeignKey}}')->unsigned();
            $table->foreign('{{$roleForeignKey}}')->references('id')->on('{{$rolesTable}}')->onUpdate('cascade')->onDelete('cascade');
        });
        // Create table for storing persona_permission
        Schema::create('{{$personaPermissionTable}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('{{$personaForeignKey}}')->unsigned();
            $table->foreign('{{$personaForeignKey}}')->references('id')->on('{{$personaTable}}');
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
        Schema::drop('{{$personaPermissionTable}}');
        Schema::drop('{{$personaRoleTable}}');
        Schema::drop('{{$personaTable}}');
        Schema::drop('{{$permissionRoleTable}}');
        Schema::drop('{{$permissionsTable}}');
        Schema::drop('{{$rolesTable}}');
    }
}
