<?php

namespace App\Models\Common;

use App\Models\BaseModel;

class PrimaryKeyInfo extends BaseModel
{
    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'primary_key_info';

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $guarded = [];
}
