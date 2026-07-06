<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Features;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            [
                'icon_image' => 'fast-delivery.png',
                'en_title' => 'Fast Delivery',
                'ar_title' => 'توصيل سريع',
                'en_text' => 'Get your products delivered to your doorstep within 24 hours',
                'ar_text' => 'احصل على منتجاتك في غضون 24 ساعة'
            ],
            [
                'icon_image' => 'quality-products.png',
                'en_title' => 'Quality Products',
                'ar_title' => 'منتجات عالية الجودة',
                'en_text' => 'We guarantee the highest quality products from trusted suppliers',
                'ar_text' => 'نضمن أعلى جودة للمنتجات من موردين موثوق بهم'
            ],
            [
                'icon_image' => 'customer-support.png',
                'en_title' => '24/7 Support',
                'ar_title' => 'دعم على مدار الساعة',
                'en_text' => 'Our customer support team is available 24/7 to assist you',
                'ar_text' => 'فريق دعم العملاء متاح على مدار الساعة لمساعدتك'
            ]
        ];

        foreach ($features as $feature) {
            Features::create($feature);
        }
    }
} 