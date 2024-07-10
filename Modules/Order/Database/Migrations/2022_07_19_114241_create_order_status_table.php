<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Order\Entities\OrderStatus;

class CreateOrderStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->timestamps();
        });

        $OrderStatus = [
            ['en' => 'order sent to branch', 'ar' => 'تم ارسال الطلب'],
            ['en' => 'Accepted and  preparing', 'ar' => 'مقبول وجاري التحضير'],
            ['en' => 'Deliver order to driver', 'ar' => 'تسليم الطلب للسائق'],
            ['en' => 'on the way', 'ar' => 'جاري التوصيل للعميل'],
            ['en' => 'Done', 'ar' => 'تم التوصيل بنجاح'],
            ['en' => 'refused order from driver', 'ar' => 'الطلبات المرفوضة من السائق'],
            ['en' => 'Fail', 'ar' => 'فشل في توصيل الطلب للعميل'],
            ['en' => 'cancelled', 'ar' => 'تم الغاء الطلب'],

        ];
        foreach ($OrderStatus as $data) {

            OrderStatus::create(['title' => $data]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status');
    }
}
