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

        return response()->json($data);
    }

    public function getData($id)
    {
        $data = DataPenjualan::where('id', $id)->first();
        if (!$data) {
            return $this->responError(0, "Data Penjualan Tidak Ditemukan");
        }

        return response()->json($data);
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

        return response()->json($data);
    }

    public function deleteData($id)
    {
        $data = DataPenjualan::findOrFail($id)->first();
        if (!$data) {
            return $this->responError(0, "Data Penjualan Tidak Ditemukan");
        }

        $data->delete();

        return response()->json($data);
    }

    public function getAllData()
    {
        $data = DataPenjualan::all();
        if (!$data) {
            return $this->responError(0, "Data Penjualan Belum Ditambahkan");
        }
        return response()->json($data);
    }

    public function searchData(Request $request)
    {
        $keyword = $request->search;
        $dataempty =  DataPenjualan::where('nama_barang', 'like', "%" . $keyword . "%")->orWhere('jenis_barang', 'like', "%" . $keyword . "%")->first();

        if (!$dataempty) {
            return $this->responError(0, "Hasil Pencarian '$keyword' Tidak ada");
        }

        $data =  DataPenjualan::where('nama_barang', 'like', "%" . $keyword . "%")->orWhere('jenis_barang', 'like', "%" . $keyword . "%")->get();

        return response()->json($data);
    }

    public function responError($sts, $pesan)
    {
        return response()->json([
            'status'    => $sts,
            'message'   => $pesan
        ], Response::HTTP_UNAUTHORIZED);
    }
}
