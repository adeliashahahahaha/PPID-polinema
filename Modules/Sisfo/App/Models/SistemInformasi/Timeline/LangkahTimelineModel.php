<?php

namespace App\Models\SistemInformasi\Timeline;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LangkahTimelineModel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 't_langkah_timeline';
    protected $primaryKey = 'langkah_timeline_id';
    protected $fillable = [
        'fk_m_timeline',
        'langkah_timeline',
    ];

    public function Timeline()
    {
        return $this->belongsTo(TimelineModel::class, 'fk_m_timeline', 'timeline_id');
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
