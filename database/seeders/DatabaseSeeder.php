<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Item;
use App\Models\User;
use App\Models\Item_detail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'username' => 'rizky',
            'email' => 'cahzello@gmail.com',
            'password' => bcrypt('24maret2006'),
            'role' => 'admin'

        ]);

        Item::create([
            'user_id' => 1,
            'bahan_baku' => 'Tepung Tapioka'
        ]);

        $data = [
            'bulan' => ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'],
            'beli' => [1800, 1900, 1800, 1950, 1950, 1850, 1900, 1850, 1800, 1700, 1750, 1800],
            'penggunaan' => [1950, 1750, 1650, 1790, 1950, 1900, 1925, 1725, 1830, 1650, 1530, 1900],
        ];

        foreach ($data['bulan'] as $i => $bulan) {
            $beli = $data['beli'][$i];
            $penggunaan = $data['penggunaan'][$i];
        
            Item_detail::create([
                'item_id' => 1,
                'bulan' => $bulan,
                'jumlah_pembelian' => $beli,
                'jumlah_penggunaan' => $penggunaan,
                'biaya_pemesanan' => 47916.666,
                'biaya_penyimpanan' => 154.166,
                'leadtime' => 0.25,
            ]);
        }
    }
}
