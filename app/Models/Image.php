<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Image
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $code Image Unique Code
 * @property string $delete_code Image Delete Code
 * @property string $name Image File Name
 * @property string $ext Image Extension
 * @property int $width Image Width in Pixels
 * @property int $height Image Height in Pixels
 * @property int $nsfw Normal or NSFW
 * @property string $uploader_ip Image Uploader IP
 * @property string $fingerprint Image Fingerprint
 * @property string $save_name Image Save Name
 * @property int $size Image Size in Bits
 * @property int $views Image View Counts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereDeleteCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereFingerprint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereNsfw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereSaveName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUploaderIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereWidth($value)
 */
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
