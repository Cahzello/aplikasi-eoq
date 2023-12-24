<?php

namespace App\Http\Controllers;

use App\Models\Calculate;
use App\Models\Item;
use App\Models\Item_detail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function redirect()
    {
        return back();
    }

    public function show()
    {
        return view('input.index', [
            'active' => 'input'
        ]);
    }

    public function listdata()
    {   
        $data = Item::all();

        return view('input.listdata', [
            'active' => 'input',
            'responses' => $data
        ]);
    }

    public function inputmonth()
    {   
        $month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('input.month', [
            'active' => 'input',
            'months' => $month
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bahan_baku' => 'required|string|max:255',
        ]);

        $user_id = auth()->user()->id;
        $validatedData['user_id'] = $user_id;
        $bulan = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

        $item = Item::create($validatedData);
        $arr = [];

        foreach ($bulan as $value){
            $arr['item_id'] = $item->id;
            $arr['bulan'] = $value;
            Item_detail::create($arr);
        }

        return redirect('/rekapan-bulanan')->with('success', 'data berhasil di input');
    }


    public function calculation($request)
    {
        $bahanBaku = $request->bahan_baku;
        $penggunaanTotal = $request->total_penggunaan_tahunan;
        $biayaPemesanan = $request->biaya_pemesanan;
        $biayaPerUnit = $request->biaya_penyimpanan;
        $penggunaanMax = $request->max_penggunaan_tahunan;
        $penggunaanAverage = $request->average_penggunaan_tahunan;
        $leadtime = $request->leadtime;
        $average_pembelian = $request->average_pembelian;
        $frekuensi_konvensional = 12;

        $totalEoq = sqrt(2 * $penggunaanTotal * $biayaPemesanan / $biayaPerUnit);
        $frekuensi = $penggunaanTotal / $totalEoq;
        $safetyStock = $this->safety_stock($penggunaanMax, $penggunaanAverage, $leadtime);
        $reorderPoint = $this->reorder_point($penggunaanAverage, $safetyStock, $leadtime);


        $arr = [
            'bahan_baku' => $bahanBaku,
            'eoq' => $totalEoq,
            'rop' => $reorderPoint,
            'safety_stock' => $safetyStock,
            'frekuensi' => $frekuensi,
            'frekuensi_konvensional' => $frekuensi_konvensional,
            'average_pembelian' => $average_pembelian
        ];

        return $arr;
    }

    public function safety_stock($penggunaanMax, $penggunaanAverage, $leadtime)
    {

        $hasil_sementara =  $penggunaanMax - $penggunaanAverage;
        $hasil = $hasil_sementara * $leadtime;

        return $hasil;
    }

    public function reorder_point($penggunaanAverage, $safetyStock, $leadtime)
    {
        $waktu = $penggunaanAverage / 30;

        $hasil_sementara = ($leadtime * $waktu) + $safetyStock;

        return $hasil_sementara;
    }

    public function update(Request $request, Product $data)
    {
        $validatedData = $request->validate([
            'bahan_baku' => 'required|string|max:255',
            'total_penggunaan_tahunan' => 'required|numeric',
            'biaya_pemesanan' => 'required|numeric',
            'biaya_penyimpanan' => 'required|numeric',
            'max_penggunaan_tahunan' => 'required|numeric',
            'average_penggunaan_tahunan' => 'required|numeric',
            'average_pembelian' => 'required|numeric',
            'leadtime' => 'required|numeric',
        ]);

        $validatedData['user_id'] = $data->user_id;

        $arr = $this->calculation($request);

        Product::where('id', $data->id)->update($validatedData);

        Calculate::where('product_id', $data->id)->update($arr);

        return redirect('/data')->with('success', 'Data telah berhasil diubah');
    }

    public function delete(Product $data)
    {
        Product::where('id', $data->id)->delete();
        Calculate::where('product_id', $data->id)->delete();

        return redirect('/data')->with('success', 'Data telah berhasil dihapus');
    }
}