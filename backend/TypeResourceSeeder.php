<?php

namespace Database\Seeders;

use App\Models\TypeResource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (TypeResource::TYPES as $type){
            DB::table('type_resources')->insert([
                'name' => $type
            ]);
        }
    }
}
