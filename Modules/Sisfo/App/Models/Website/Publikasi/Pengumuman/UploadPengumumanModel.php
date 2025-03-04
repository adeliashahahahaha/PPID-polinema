<?php

namespace App\Models\Website\Publikasi\Pengumuman;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadPengumumanModel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 't_upload_pengumuman';
    protected $primaryKey = 'upload_pengumuman_id';
    protected $fillable = [
        'fk_t_pengumuman',
        'up_thumbnail',
        'up_type',
        'up_value'
    ];

    public function Pengumuman()
    {
        return $this->belongsTo(PengumumanModel::class, 'fk_t_pengumuman', 'pengumuman_id');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = array_merge($this->fillable, $this->getCommonFields());
    }

    public static function selectData()
    {
      //
    }

    public static function createData()
    {
      //
    }

    public static function updateData()
    {
        //
    }

    public static function deleteData()
    {
        //
    }

    public static function validasiData()
    {
        //
    }
}
