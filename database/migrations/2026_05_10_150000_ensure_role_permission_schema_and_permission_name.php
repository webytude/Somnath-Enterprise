<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('module')->nullable();
                $table->string('action')->nullable();
                $table->timestamps();
            });
        } else {
            if (Schema::hasColumn('permissions', 'route_name')) {
                if (!Schema::hasColumn('permissions', 'name')) {
                    Schema::table('permissions', function (Blueprint $table) {
                        $table->string('name')->nullable()->after('id');
                    });
                    DB::statement('UPDATE permissions SET name = route_name WHERE name IS NULL OR name = \'\'');
                    Schema::table('permissions', function (Blueprint $table) {
                        $table->dropColumn('route_name');
                    });
                } else {
                    Schema::table('permissions', function (Blueprint $table) {
                        $table->dropColumn('route_name');
                    });
                }
            } elseif (!Schema::hasColumn('permissions', 'name')) {
                Schema::table('permissions', function (Blueprint $table) {
                    $table->string('name')->unique()->after('id');
                });
            }
        }

        if (!Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
                $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['role_id', 'permission_id']);
            });
        }

        if (Schema::hasTable('users') && Schema::hasTable('roles') && !Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('role_id')->nullable()->after('is_staff')->constrained('roles')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropConstrainedForeignId('role_id');
            });
        }
    }
};
