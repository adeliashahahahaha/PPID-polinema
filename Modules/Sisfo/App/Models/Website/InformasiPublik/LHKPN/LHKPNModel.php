<?php

namespace Modules\Sisfo\App\Models\Website\InformasiPublik\LHKPN;

use Modules\Sisfo\App\Models\Log\TransactionModel;
use Modules\Sisfo\App\Models\TraitsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LhkpnModel extends Model
{
    use TraitsModel;

    protected $table = 'm_lhkpn';
    protected $primaryKey = 'lhkpn_id';
    protected $fillable = [
        'lhkpn_tahun',
        'lhkpn_judul_informasi',
        'lhkpn_deskripsi_informasi'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = array_merge($this->fillable, $this->getCommonFields());
    }

    // public static function getDataLhkpn($request = null)
    // {
    //     // Parameter default
    //     $perPage = $request->input('per_page', 10);
    //     $page = $request->input('page', 1);
    //     $tahun = $request->input('tahun', null);
    //     $search = $request->input('search', '');

    //     // Query dasar untuk LHKPN
    //     $query = self::where('isDeleted', 0)
    //         ->select(
    //             'lhkpn_id',
    //             'lhkpn_tahun',
    //             'lhkpn_judul_informasi',
    //             'lhkpn_deskripsi_informasi',
    //             'updated_at' // Tambahkan kolom updated_at
    //         )
    //         ->orderBy('lhkpn_tahun', 'desc');

    //     // Filter berdasarkan tahun jika diberikan
    //     if ($tahun !== null) {
    //         $query->where('lhkpn_tahun', $tahun);
    //     }

    //     // Filter pencarian jika ada
    //     if (!empty($search)) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('lhkpn_judul_informasi', 'like', "%{$search}%")
    //                 ->orWhere('lhkpn_deskripsi_informasi', 'like', "%{$search}%")
    //                 ->orWhere('lhkpn_tahun', 'like', "%{$search}%");
    //         });
    //     }

    //     // Ambil data dengan pagination
    //     $lhkpnData = $query->paginate($perPage);

    //     // Tambahkan detail karyawan untuk setiap LHKPN
    //     $lhkpnData->getCollection()->transform(function ($lhkpn) {
    //         // Ambil detail karyawan untuk LHKPN ini
    //         $details = DetailLhkpnModel::where('fk_m_lhkpn', $lhkpn->lhkpn_id)
    //             ->where('isDeleted', 0)
    //             ->select(
    //                 'detail_lhkpn_id',
    //                 'dl_nama_karyawan',
    //                 'dl_file_lhkpn'
    //             )
    //             ->orderBy('dl_nama_karyawan')
    //             ->offset(0)
    //             ->limit(10) // Batasi 10 karyawan pertama
    //             ->get()
    //             ->map(function ($detail) {
    //                 return [
    //                     'id' => $detail->detail_lhkpn_id,
    //                     'nama_karyawan' => $detail->dl_nama_karyawan,
    //                     'file' => $detail->dl_file_lhkpn
    //                         ? asset('storage/lhkpn/' . $detail->dl_file_lhkpn)
    //                         : null
    //                 ];
    //             });

    //         // Hitung total karyawan
    //         $totalKaryawan = DetailLhkpnModel::where('fk_m_lhkpn', $lhkpn->lhkpn_id)
    //             ->where('isDeleted', 0)
    //             ->count();

    //         return [
    //             'id' => $lhkpn->lhkpn_id,
    //             'tahun' => $lhkpn->lhkpn_tahun,
    //             'judul' => $lhkpn->lhkpn_judul_informasi,
    //             'deskripsi' => $lhkpn->lhkpn_deskripsi_informasi,
    //             'updated_at' => $lhkpn->updated_at ? $lhkpn->updated_at->format('d M Y, H:i:s') : null, // Format tanggal opsional
    //             'details' => $details,
    //             'total_karyawan' => $totalKaryawan,
    //             'has_more' => $totalKaryawan > 10
    //         ];
    //     });


    //     return $lhkpnData;
    // }
    public static function getDataLhkpn($per_page = 5, $tahun = null, $page = 1)
    {
        // Base query for LHKPN 
        $query = DB::table('m_lhkpn as ml')
            ->select([
                'ml.lhkpn_id',
                'ml.lhkpn_tahun',
                'ml.lhkpn_judul_informasi',
                'ml.lhkpn_deskripsi_informasi',
                'ml.updated_at'
            ])
            ->where('ml.isDeleted', 0);
    
        // Filter by year if provided
        if ($tahun !== null) {
            $query->where('ml.lhkpn_tahun', $tahun);
        }
    
        // Get LHKPN data ordered by year
        $lhkpnData = $query->orderBy('ml.lhkpn_id', 'asc')->get();
    
        // Transform the data
        $transformedData = $lhkpnData->map(function ($lhkpn) use ($per_page, $page) {
            // Fetch ALL details for each LHKPN
            $allDetails = DB::table('t_detail_lhkpn')
                ->where('fk_m_lhkpn', $lhkpn->lhkpn_id)
                ->where('isDeleted', 0)
                ->select(
                    'detail_lhkpn_id',
                    'dl_nama_karyawan',
                    'dl_file_lhkpn'
                )
                ->orderBy('dl_nama_karyawan')
                ->get();
    
            // Paginate the details
            $totalDetails = $allDetails->count();
            $totalPages = ceil($totalDetails / $per_page);
            $offset = ($page - 1) * $per_page;
            $paginatedDetails = $allDetails->slice($offset, $per_page);
    
            // Transform details
            $details = $paginatedDetails->map(function ($detail) {
                return [
                    'id' => $detail->detail_lhkpn_id,
                    'nama_karyawan' => $detail->dl_nama_karyawan,
                    'file' => $detail->dl_file_lhkpn
                        ? asset('storage/' . $detail->dl_file_lhkpn)
                        : null
                ];
            });
    
            // Format update date
            $tanggalUpdate = $lhkpn->updated_at
                ? \Carbon\Carbon::parse($lhkpn->updated_at)->format('d F Y, H:i:s')
                : null;
    
            $deskripsi = trim($lhkpn->lhkpn_deskripsi_informasi);
            // $deskripsi = preg_replace('/<[^>]*>/', '', trim($lhkpn->lhkpn_deskripsi_informasi));
    
            // Prepare pagination info
            $nextPage = $page < $totalPages ? $page + 1 : null;
            $prevPage = $page > 1 ? $page - 1 : null;
    
            return [
                'id' => $lhkpn->lhkpn_id,
                'tahun' => $lhkpn->lhkpn_tahun,
                'judul' => $lhkpn->lhkpn_judul_informasi,
                'deskripsi' => $deskripsi,
                'updated_at' => $tanggalUpdate,
                'details' => $details,
                'total_karyawan' => $totalDetails,
                'current_page' => $page,
                'total_pages' => $totalPages,
                'next_page' => $nextPage,
                'prev_page' => $prevPage
            ];
        })->toArray();
    
        // Return response
        return [
            'success' => true,
            'message' => 'Data LHKPN berhasil diambil.',
            'data' => [
                'current_page' => $page,
                'data' => $transformedData,
                'total_pages' => 1, 
                'total_items' => count($lhkpnData),
                'per_page' => $per_page
            ]
        ];
    }
    public static function selectData($perPage = null, $search = '')
    {
        $query = self::query()
            ->where('isDeleted', 0);

        // Tambahkan fungsionalitas pencarian
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('lhkpn_tahun', 'like', "%{$search}%")
                  ->orWhere('lhkpn_judul_informasi', 'like', "%{$search}%");
            });
        }

        
        return self::paginateResults($query, $perPage);
    }

    public static function createData($request)
    {
        try {
            DB::beginTransaction();

            $data = $request->m_lhkpn;
            $lhkpn = self::create($data);

            TransactionModel::createData(
                'CREATED',
                $lhkpn->lhkpn_id,
                $lhkpn->lhkpn_judul_informasi
            );

            DB::commit();

            return self::responFormatSukses($lhkpn, 'Data LHKPN berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return self::responFormatError($e, 'Gagal membuat data LHKPN');
        }
    }

    public static function updateData($request, $id)
    {
        try {
            DB::beginTransaction();

            $lhkpn = self::findOrFail($id);
            
            $data = $request->m_lhkpn;
            $lhkpn->update($data);

            TransactionModel::createData(
                'UPDATED',
                $lhkpn->lhkpn_id, 
                $lhkpn->lhkpn_judul_informasi 
            );

            DB::commit();

            return self::responFormatSukses($lhkpn, 'Data LHKPN berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return self::responFormatError($e, 'Gagal memperbarui data LHKPN');
        }
    }

    public static function deleteData($id)
    {
        try {
            DB::beginTransaction();
            
            $lhkpn = self::findOrFail($id);
            
            $lhkpn->delete();

            TransactionModel::createData(
                'DELETED',
                $lhkpn->lhkpn_id,
                $lhkpn->lhkpn_judul_informasi
            );
                
            DB::commit();

            return self::responFormatSukses($lhkpn, 'Data LHKPN berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return self::responFormatError($e, 'Gagal menghapus data LHKPN');
        }
    }

    public static function detailData($id) {
        return self::findOrFail($id);
    }

    public static function validasiData($request)
    {
        $rules = [
            'm_lhkpn.lhkpn_tahun' => 'required|max:4',
            'm_lhkpn.lhkpn_judul_informasi' => 'required|max:255',
            'm_lhkpn.lhkpn_deskripsi_informasi' => 'required',
        ];

        $messages = [
            'm_lhkpn.lhkpn_tahun.required' => 'Tahun LHKPN wajib diisi',
            'm_lhkpn.lhkpn_tahun.max' => 'Tahun LHKPN maksimal 4 karakter',
            'm_lhkpn.lhkpn_judul_informasi.required' => 'Judul informasi wajib diisi',
            'm_lhkpn.lhkpn_judul_informasi.max' => 'Judul informasi maksimal 255 karakter',
            'm_lhkpn.lhkpn_deskripsi_informasi.required' => 'Deskripsi informasi wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}