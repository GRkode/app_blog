<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Plan mensuel',
            'slug' => 'plan-mensuel',
            'stripe_name' => 'mensuel',
            'stripe_product_id' => 'prod_KyIKakCLBnsQK9',
            'stripe_price_id' => 'price_1KILjuH39D4rZO7QwkFAua6D',
            'price' => 2,
            'abbreviation' => '/Mois',
        ]);

        Plan::create([
            'name' => 'Plan unique',
            'slug' => 'plan-unique',
            'stripe_name' => 'unique',
            'stripe_product_id' => 'prod_KyILc9yXbjBe9b',
            'stripe_price_id' => 'price_1KILl6H39D4rZO7QmFQ4ziIT',
            'price' => 1,
            'abbreviation' => '/Unité',
        ]);
    }
}
