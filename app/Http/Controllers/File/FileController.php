<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File as FileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    /**
     * Tampilkan daftar file milik pengguna yang login.
     */
    public function index(Request $request)
    {
        $files = auth()->user()
            ->files()
            ->with('folder')
            ->latest()
            ->get();

        return view('dashboard', compact('files'));
    }

    /**
     * Unggah berkas ke Supabase Storage dan simpan metadata ke PostgreSQL.
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip,rar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $uploadedFile = $request->file('file');
        $user = Auth::user();
        $extension = $uploadedFile->getClientOriginalExtension();
        $storagePath = null;

        try {
            // Upload objek ke Supabase Storage
            $storedPath = $uploadedFile->storeAs(
                'users/' . $user->id . '/files',
                Str::uuid() . '.' . $extension,
                ['disk' => 'supabase']
            );

            // Simpan metadata ke PostgreSQL
            $file = FileModel::create([
                'user_id' => $user->id,
                'folder_id' => null,
                'name' => $uploadedFile->getClientOriginalName(),
                'original_name' => $uploadedFile->getClientOriginalName(),
                'storage_path' => $storedPath,
                'mime_type' => $uploadedFile->getMimeType(),
                'size' => $uploadedFile->getSize(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diunggah.',
                'file' => [
                    'id' => $file->id,
                    'name' => $file->name,
                    'original_name' => $file->original_name,
                    'size' => $file->size,
                    'mime_type' => $file->mime_type,
                    'storage_path' => $file->storage_path,
                    'created_at' => $file->created_at,
                ],
            ]);
        } catch (\Throwable $e) {
            // Kompensasi: jika metadata gagal disimpan tapi objek sudah ter-upload,
            // hapus objek dari storage.
            if (!empty($storedPath)) {
                try {
                    Storage::disk('supabase')->delete($storedPath);
                } catch (\Throwable $deleteError) {
                    Log::error('Gagal menghapus objek setelah gagal menyimpan metadata: ' . $deleteError->getMessage());
                }
            }

            Log::error('Gagal mengunggah berkas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah berkas. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Unduh berkas dari Supabase Storage dengan pemeriksaan kepemilikan.
     */
    public function download(Request $request, FileModel $file)
    {
        if ($file->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengakses berkas ini.');
        }

        if (!$file->storage_path) {
            abort(404, 'Berkas tidak tersedia.');
        }

        $disk = Storage::disk('supabase');

        if (!$disk->exists($file->storage_path)) {
            abort(404, 'Objek berkas tidak ditemukan di storage.');
        }

        return $disk->download($file->storage_path, $file->original_name);
    }
}
