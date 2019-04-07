<?php

use Illuminate\Database\Seeder;

use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => "江河自补剂",
            'type' => "标准型",
            'info' => '{
                "list": {"最低温度":"0 ℃", "包装":"400毫升/瓶", "箱数量":36},
                "img": "1.jpg"
            }'
        ]);
        Product::create([
            'name' => "江河自补剂",
            'type' => "抗冻型",
            'info' => '{
                "list": {"最低温度":"- 15 ℃", "包装":"400毫升/瓶", "箱数量":36},
                "img": "2.jpg"
            }'
        ]);
    }
}
