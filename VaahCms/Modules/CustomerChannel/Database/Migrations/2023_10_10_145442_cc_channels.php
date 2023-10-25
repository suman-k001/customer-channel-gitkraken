<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CcChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('cc_channels')) {
            Schema::create('cc_channels', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->uuid('uuid')->nullable()->index();

                $table->string('name')->nullable()->index();
                $table->string('slug')->nullable()->index();
                $table->bigInteger('customer_id')->unsigned();
                $table->foreign('customer_id')->references('id')->on('cc_customers')->onDelete('cascade');
                $table->string('URL')->nullable()->index();
                $table->integer('locale_id')->unsigned()->nullable()->index();
                $table->foreign('locale_id')->references('id')->on('vh_taxonomies');


                $table->integer('currency_id')->unsigned()->nullable()->index();
                $table->foreign('currency_id')->references('id')->on('vh_taxonomies');

                $table->integer('type_id')->unsigned()->nullable()->index();
                $table->foreign('type_id')->references('id')->on('vh_taxonomies');

                $table->boolean('confirmation')->nullable()->index();
                $table->boolean('is_active')->nullable()->index();

                //----common fields
                $table->text('meta')->nullable();
                $table->bigInteger('created_by')->nullable()->index();
                $table->bigInteger('updated_by')->nullable()->index();
                $table->bigInteger('deleted_by')->nullable()->index();
                $table->timestamps();
                $table->softDeletes();
                $table->index(['created_at', 'updated_at', 'deleted_at']);
                //----/common fields

            });
        }

    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('cc_channels');
    }
}
