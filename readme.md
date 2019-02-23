# sekolahapi
![alt text](https://github.com/mohripan/sekolahapi/blob/master/hasil.jpg)

## Pengertian
Sekolah API adalah project yang dibuat menggunakan laravel dengan lumen-API yang merupakan sebuah framework modern lainnya menggunakan **composer** untuk mengelola *dependency (package)* yang berada di dalamnya. Bisa dikatakan, lumen-API ini digunakan untuk memudahkan kita sebagai *developer* untuk membuat sebuah API.

## Cara Install
1. Buka **cmd** yang berada di pc/laptop kalian, lalu arahkan ke folder yang akan digunakan untuk menginstall project.
2. Ketik `composer create-project laravel/lumen nama-project --prefer-dist`
3. Tunggu beberapa saat, lalu buka projectnya.

## Bedah Coding
1. Membuat database terlebih dahulu yang bernama *api_sekolah* (Bisa menggunakan *pypmyadmin* atau aplikasi yang lain)
2. Buka .env, lalu edit kodingan

### Sebelum
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### Sesudah
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

3. Membuat table t_kelas dengan cara migrate.
Ketik : `php artisan make:migration create_t_kelas`

4. Hapus Comment pada file `bootstrap/app`
```
$app->withFacades();

$app->withEloquent();
```

5. Karena telah melakukan migrasi, maka migrasi t_kelas akan muncul di `database/migrations/(waktu_pembuatan)nama_migrasi`. Update kodingan *up function* menjadi seperti di bawah
```
public function up()
    {
        Schema::create('t_kelas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_kelas', 50);
            $table->string('jurusan', 50);
            $table->timestamps();
        });
    }
```

6. Setelah selesai itu, maka kita akan membuat `Kelas.php` di dalam folder `App`
```
<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model {

	protected $table = 't_kelas';

    protected $fillable = ['id', 'nama_kelas', 'jurusan'];

    // Relationships

}

```

7. Jika *class Kelas* sudah dibuat, maka kita tinggal membuat kontrollernya.
```
<?php

namespace App\Http\Controllers;

use App\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
  public function create(Request $request)
  {
    $validation = Validator::make($request->all(),
    [
      'id'=>'required|max:10',
      'nama_kelas'=>'required|string',
      'jurusan'=>'required|string',
    ]);

    if($validation->fails())
    {
      $errors = $validation->errors();
      return
      [
        'status'=>'error',
        'message'=>$errors,
        'result'=>null
      ];
    }

    $result = \App\Kelas::create($request->all());
    if($result)
    {
      return
      [
        'status'=>'success',
        'message'=>'Data berhasil ditambahkan',
        'result'=>$result
      ];
    }
    else {
      return
      [
        'status'=>'error',
        'message'=>'Data gagal ditambahkan',
        'result'=>null
      ];
    }
  }

  public function read(Request $request)
  {
    $result = \App\Kelas::all();
    return
    [
      'status'=>'success',
      'message'=>'',
      'result'=>$result
    ];
  }

  public function update(Request $request, $id)
  {
    $validation = Validator::make($request->all(),
    [
      'id'=>'required|max:10',
      'nama_kelas'=>'required|string',
      'jurusan'=>'required|string'
    ]);

    if($validation->fails())
    {
      $errors = $validation->errors();
      return
      [
        'status'=>'errors',
        'message'=>$errors,
        'result'=>null
      ];
    }

    $kelas = \App\Kelas::find($id);
    if(empty($kelas))
    {
      return
      [
        'status'=>'error',
        'message'=>'Data tidak ditemukan',
        'result'=>null
      ];
    }

    $result = $kelas->update($request->all());
    if($result)
    {
      return
      [
        'status'=>'success',
        'message'=>'Data berhasil diubah',
        'result'=>$result
      ];
    }
    else
    {
      return
      [
        'status'=>'error',
        'message'=>'Data gagal diubah',
        'result'=>null
      ];
    }
  }

  public function delete(Request $request, $id) {
		$kelas = \App\kelas::find($id);

		if (empty($kelas)) {
			return [
				'status' => 'Error',
				'message' => 'Data not found',
				'result' => null
			];
		}

		$result = $kelas->delete($id);

		if ($result) {
			return [
				'status' => 'Success',
				'message' => 'Data successfully deleted',
				'result' => $result
			];
		} else {
			return [
				'status' => 'Error',
				'message' => 'Failed to delete data',
				'result' => null
			];
		}
	}
}

```
### Pengertian dalam KelasController
1. Hal yang pertama kita lakukan adalah tentu saja mengimport beberapa komponen yang dibutuhkan.
2. Lalu, setelah itu kita membuat beberapa function yang berfungsi untuk menambah, mengupdate dan menghapus data di dalam table t_kelas.
3. Jika kita teliti lagi, di dalam kode itu terdapat handling untuk menangani error. Handling tersebut dapat dicoba di dalam sebuah software yang bernama *postman* untuk mencoba apakah project yang kita buat dapat berjalan dengan lancar, dan apakah handling yang kita buat berjalan dengan baik atau tidak.
Link Postman : https://www.getpostman.com/

8. Terakhir, kita ubah `router/web.php` di dalam project kita. Router yang kita buat akan menjadi seperti ini :
```
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/siswa','SiswaController@create');
$router->get('/siswa','SiswaController@read');
$router->post('/siswa/{id}', 'SiswaController@update');
$router->delete('/siswa/{id}','SiswaController@delete');
$router->post('/kelas','KelasController@create');
$router->get('/kelas','KelasController@read');
$router->post('/kelas/{id}','KelasController@update');
$router->delete('/kelas/{id}','KelasController@delete');

```
