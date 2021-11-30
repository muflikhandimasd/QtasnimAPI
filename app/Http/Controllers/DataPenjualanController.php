<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPenjualan;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DataPenjualanController extends Controller
{
    public function createData(Request $request)
    {
        $pesan = [
            'nama_barang.required'          => "Nama Barang tidak boleh kosong",
            'stok.required'                 => "Stok tidak boleh kosong",
            'jumlah_terjual.required'       => "Jumlah Terjual tidak boleh kosong",
            'jenis_barang.required'         => "Jenis Barang wajib dipilih",
            'tanggal_transaksi.required'    => "Tanggal transaksi wajib dipilih",
        ];

        $validasi = Validator::make($request->all(), [
            'nama_barang'           => 'required',
            'stok'                  => 'required',
            'jumlah_terjual'        => 'required',
            'jenis_barang'          => 'required',
            'tanggal_transaksi'     => 'required'
        ], $pesan);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->responError(0, $val[0]);
        }

        $data = DataPenjualan::create([
            'nama_barang'            => $request->nama_barang,
            'stok'                   => $request->stok,
            'jumlah_terjual'         => $request->jumlah_terjual,
            'jenis_barang'           => $request->jenis_barang,
            'tanggal_transaksi'      => $request->tanggal_transaksi
        ]);

        return response()->json([
            'status'   => 1,
            'pesan'    => "Data Penjualan $request->nama_barang Berhasil Dibuat",
            'data'     => $data
        ], Response::HTTP_OK);
    }

    public function getData($id)
    {
        $data = DataPenjualan::where('id', $id)->first();
        if (!$data) {
            return $this->responError(0, "Data Penjualan Tidak Ditemukan");
        }

        return response()->json([
            'status'    => 1,
            'message'   => "Berhasil Mendapatkan Data Penjualan",
            'result'    => $data
        ], Response::HTTP_OK);
    }

    public function editData(Request $request, $id)
    {
        $data = DataPenjualan::where('id', $id)->first();

        if (!$data) {
            return $this->responError(0, "Data Penjualan Tidak Ditemukan");
        }

        $validasi = Validator::make($request->all(), [
            'nama_barang'           => 'required',
            'stok'                  => 'required',
            'jumlah_terjual'        => 'required',
            'jenis_barang'          => 'required',
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->responError(0, $val[0]);
        }

        $data->update([
            'nama_barang'            => $request->nama_barang,
            'stok'                   => $request->stok,
            'jumlah_terjual'         => $request->jumlah_terjual,
            'jenis_barang'           => $request->jenis_barang,
            'tanggal_transaksi'      => $request->tanggal_transaksi
        ]);

        return response()->json([
            'status'   => 1,
            'pesan'    => "Data Penjualan Berhasil diupdate!",
            'data'     => $data
        ], Response::HTTP_OK);
    }

    public function deleteData($id)
    {
        $data = DataPenjualan::findOrFail($id)->first();
        if (!$data) {
            return $this->responError(0, "Data Penjualan Tidak Ditemukan");
        }

        $data->delete();

        return response()->json([
            'status'   => 1,
            'pesan'    => "Data Penjualan $data->nama_barang berhasil dihapus",
        ], Response::HTTP_OK);
    }

    public function sortByNameData()
    {
        $collection = collect([
            ['id' => 1, 'name' => 'John', 'email' => 'john@gmail.com'],
            ['id' => 2, 'name' => 'Sam', 'email' => 'sam@gmail.com'],
            ['id' => 3, 'name' => 'Bilal', 'email' => 'bilal@gmail.com'],
            ['id' => 4, 'name' => 'Lisa', 'email' => 'lisa@gmail.com'],
            ['id' => 5, 'name' => 'Samuel', 'email' => 'samuel@gmail.com']
        ]);

        $filterd = $collection->sortBy('name');

        $filterd->all();

        print_r($filterd);
    }

    public function sortByTwoFields()
    {
        $collection = collect([
            ['id' => 1, 'name' => 'John', 'email' => 'john@gmail.com'],
            ['id' => 2, 'name' => 'Sam', 'email' => 'sam@gmail.com'],
            ['id' => 3, 'name' => 'Bilal', 'email' => 'bilal@gmail.com'],
            ['id' => 4, 'name' => 'Lisa', 'email' => 'lisa@gmail.com'],
            ['id' => 5, 'name' => 'Samuel', 'email' => 'samuel@gmail.com']
        ]);

        $filterd = $collection->sortBy(function ($data, $key) {
            return $data['name'] . $data['email'];
        });

        $filterd->all();

        print_r($filterd);
    }

    public function sortByDate()
    {
        $collection = collect([
            ['id' => 1, 'name' => 'John', 'created_date' => '2021-03-04'],
            ['id' => 2, 'name' => 'Sam', 'created_date' => '2021-02-03'],
            ['id' => 3, 'name' => 'Bilal', 'created_date' => '2020-01-02'],
            ['id' => 4, 'name' => 'Lisa', 'created_date' => '202019-05-01'],
            ['id' => 5, 'name' => 'Samuel', 'created_date' => '2018-08-03']
        ]);

        $filterd = $collection->sortBy(function ($data, $key) {
            return $data['name'] . $data['email'];
        });

        $filterd->all();

        print_r($filterd);
    }

    public function sortByCount()
    {
        $collection = collect([
            ['id' => 1, 'name' => 'John', 'products' => ['shoes', 'belt', 'tshirt']],
            ['id' => 2, 'name' => 'Anna', 'products' => ['socks', 'handbag']],
            ['id' => 3, 'name' => 'Ricky', 'products' => ['jeans', 'sweater']],
            ['id' => 4, 'name' => 'Sam', 'products' => ['sweater', 'jacket']]
        ]);

        $filterd = $collection->sortBy(function ($data, $key) {
            return count($data['products']);
        });

        $filterd->all();

        print_r($filterd);
    }

    public function sortByRelation()
    {
        $student = DataPenjualan::get()->sortBy(function ($query) {
            return $query->subject->name;
        })
            ->all();

        dd($student);
    }

    public function searchData(Request $request)
    {
        $keyword = $request->search;
        $dataempty =  DataPenjualan::where('nama_barang', 'like', "%" . $keyword . "%")->orWhere('jenis_barang', 'like', "%" . $keyword . "%")->first();

        if (!$dataempty) {
            return $this->responError(0, "Hasil Pencarian '$keyword' Tidak ada");
        }

        $data =  DataPenjualan::where('nama_barang', 'like', "%" . $keyword . "%")->orWhere('jenis_barang', 'like', "%" . $keyword . "%")->get();

        return response()->json([
            'status'     => 1,
            'pesan'      => "Hasil Pencarian $keyword Berhasil Ditemukan",
            'result'     => $data
        ], Response::HTTP_OK);
    }

    public function responError($sts, $pesan)
    {
        return response()->json([
            'status'    => $sts,
            'message'   => $pesan
        ], Response::HTTP_UNAUTHORIZED);
    }
}
