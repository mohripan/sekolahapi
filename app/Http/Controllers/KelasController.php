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
