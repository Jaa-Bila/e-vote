<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('no_urut')->nullable();
            $table->string('no_ktp')->unique();
            $table->string('no_id');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->enum('agama', ['islam', 'kristen', 'hindu', 'buddha', 'konghucu']);
            $table->text('alamat');
            $table->string('pekerjaan');
            $table->string('provinsi')->nullable();
            $table->string('kabkota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('pendidikan_terakhir');
            $table->text('pengalaman_organisasi')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('role', ['ADMIN', 'PENGAWAS', 'PASLON', 'USER'])->default('USER');
            $table->string('foto')->nullable();
            $table->dateTime('last_login_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
