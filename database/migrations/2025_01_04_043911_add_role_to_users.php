<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('role')->default(0)->after('password');
        });

        $this->createDefaultUsers();
    }

    protected function createDefaultUsers()
    {
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@test.com',
            'password' => bcrypt('12341234')
        ]);
        $editor->role = Role::EDITOR;
        $editor->email_verified_at = now();
        $editor->save();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('12341234')
        ]);
        $admin->role = Role::ADMIN;
        $admin->email_verified_at = now();
        $admin->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
