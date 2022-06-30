<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeResource extends Model
{
    use HasFactory;

    public $table = 'type_resources';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name'];

    const PHOTO_USER = 'foto de usuario';

    const TYPES = [
        self::PHOTO_USER
    ];

    public function scopePhotoUser($query) {
        return $query->where('name', self::PHOTO_USER);
    }
}
