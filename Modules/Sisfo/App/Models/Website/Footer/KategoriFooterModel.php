<?php

namespace App\Models\Website\Footer;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriFooterModel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 't_footer';
    protected $primaryKey = 'footer_id';
    protected $fillable = [
        'fk_m_kategori_footer',
        'f_judul_footer',
        'f_icon_footer',
        'f_url_footer',
    ];

    public function KategoriFooter()
    {
        return $this->belongsTo(FooterModel::class, 'fk_m_kategori_footer', 'footer_id');
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
