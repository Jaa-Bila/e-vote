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
            $table->integer('no_urut_calon')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('nik')->unique()->nullable();
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
            $table->string('pendidikan_terakhir')->nullable();
            $table->text('pengalaman_organisasi')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->string('foto')->nullable();
            $table->smallInteger('status')->default(0);
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
