<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model {

	protected $table = 't_kelas';

    protected $fillable = ['id', 'nama_kelas', 'jurusan'];

    // Relationships

}
