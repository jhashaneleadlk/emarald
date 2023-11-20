<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class SeederManage extends Model
{
    protected $table = 'seeders_manage';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $guarded = [];
}
