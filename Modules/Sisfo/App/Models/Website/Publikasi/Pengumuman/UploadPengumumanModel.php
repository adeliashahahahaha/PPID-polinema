<?php

namespace Modules\Sisfo\App\Models\Website\Publikasi\Pengumuman;

use Modules\Sisfo\App\Models\TraitsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UploadPengumumanModel extends Model
{
    use TraitsModel;

    protected $table = 't_upload_pengumuman';
    protected $primaryKey = 'upload_pengumuman_id';
    protected $fillable = [
        'fk_t_pengumuman',
        'up_thumbnail',
        'up_type',
        'up_value',
        'up_konten',
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

    // Method untuk upload file (thumbnail atau nilai)
    public static function uploadFile($file, $folder)
    {
        if (!$file) {
            return null;
        }
        
        $fileName = $folder . '/' . Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public', $fileName);
        
        return $fileName;
    }

    // Method untuk menghapus file
    public static function removeFile($fileName)
    {
        if ($fileName) {
            $filePath = storage_path('app/public/' . $fileName);
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            }
        }
        
        return false;
    }
}