<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExactOnlineConnectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->text('access_token');
            $table->text('refresh_token');
            $table->timestamp('token_expires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(
            $this->getTableName()
        );
    }

    protected function getTableName ()
    {
        return (config('exactonline.database_table')) ?: 'exact_online_connects';
    }
}
