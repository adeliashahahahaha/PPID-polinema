<?php

namespace Modules\Sisfo\App\Models\SistemInformasi\Timeline;

use Modules\Sisfo\App\Models\TraitsModel;
use Illuminate\Database\Eloquent\Model;

class TimelineModel extends Model
{
    use TraitsModel;

    protected $table = 'm_timeline';
    protected $primaryKey = 'timeline_id';
    protected $fillable = [
        'kategori_timeline',
        'judul_timeline',
    ];

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
