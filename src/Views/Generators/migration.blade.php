<?php echo '<?php'  ?>


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
            $table->uuid('uuid')->primary();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Create table for storing permissions
        Schema::create('{{$permissionsTable}}', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Create table for storing the persona
        if (!Schema::hasTable('{{$personaTable}}')) {
            Schema::create('{{$personaTable}}', function (Blueprint $table) {
                $table->uuid('uuid')->primary();
                $table->{{$userForeignKeyType}}('{{$userForeignKey}}');
                $table->foreign('{{$userForeignKey}}')->references('{{$userKeyName}}')->on('{{$usersTable}}')->onUpdate('cascade')->onDelete('cascade');
                $table->string('{{$personableColumn}}');
                $table->{{$personableColumnForeignType}}('{{$personableColumnForeign}}');
                $table->timestamps();
            });
        };
        //Create table for storing permission_role
        Schema::create('{{$permissionRoleTable}}', function (Blueprint $table) {
            $table->uuid('{{$permissionForeignKey}}')->index();
            $table->foreign('{{$permissionForeignKey}}')->references('uuid')->on('{{$permissionsTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->uuid('{{$roleForeignKey}}')->index();
            $table->foreign('{{$roleForeignKey}}')->references('uuid')->on('{{$rolesTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        // Create table for storing persona_role
        Schema::create('{{$personaRoleTable}}', function (Blueprint $table) {
            $table->uuid('{{$personaForeignKey}}')->index();
            $table->foreign('{{$personaForeignKey}}')->references('uuid')->on('{{$personaTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->uuid('{{$roleForeignKey}}')->index();
            $table->foreign('{{$roleForeignKey}}')->references('uuid')->on('{{$rolesTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        // Create table for storing persona_permission
        Schema::create('{{$personaPermissionTable}}', function (Blueprint $table) {
            $table->uuid('{{$personaForeignKey}}')->index();
            $table->foreign('{{$personaForeignKey}}')->references('uuid')->on('{{$personaTable}}');
            $table->uuid('{{$permissionForeignKey}}')->index();
            $table->foreign('{{$permissionForeignKey}}')->references('uuid')->on('{{$permissionsTable}}')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
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
