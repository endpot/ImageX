<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'code',
        'delete_code',
        'name',
        'ext',
        'width',
        'height',
        'nsfw',
        'uploader_ip',
        'fingerprint',
        'size',
        'views',
    ];
}
