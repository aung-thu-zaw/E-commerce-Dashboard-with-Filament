<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FormatHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DatabaseBackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:database-backups.view', ['only' => ['index']]);
        $this->middleware('permission:database-backups.download', ['only' => ['download']]);
        $this->middleware('permission:database-backups.create', ['only' => ['backup']]);
        $this->middleware('permission:database-backups.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            // Get backup files
            $backupFiles = Storage::disk('local')->allFiles(env("APP_NAME"));

            $backups = collect($backupFiles)->map(function ($file) {
                return [
                    'filename' => basename($file),
                    'date' => Carbon::createFromTimestamp(Storage::disk('local')->lastModified($file))->format('j-F-Y ( g:i:s ) A'),
                    'location' => 'Local',
                    'size' => FormatHelper::humanReadableFilesize(Storage::disk('local')->size($file)),
                ];
            });

            // Disk information
            $disk = 'local';
            $diskHealth = $this->checkDiskHealth($disk);

            // Overall information
            $totalBackupStorage = collect($backupFiles)->sum(function ($file) {
                return Storage::disk('local')->size($file);
            });

            $overallInformation = [
                'disk' => $disk,
                'health' => $diskHealth,
                'amountOfBackups' => count($backups),
                'usedBackupStorage' => FormatHelper::humanReadableFilesize($totalBackupStorage),
                'lastTimeBackup' => Carbon::createFromTimestamp(Storage::disk('local')->lastModified(end($backupFiles)))->diffForHumans(),
            ];

            // Paginator
            $perPage = request('per_page', 5);
            $currentPage = request('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedBackups = array_slice($backups->all(), $offset, $perPage, true);

            $backupsPaginated = new LengthAwarePaginator(
                $paginatedBackups,
                count($backups),
                $perPage,
                $currentPage,
                [
                    'path' => route('admin.database-backups.index', ['per_page' => $perPage]),
                    'pageName' => 'page',
                ]
            );

            return response()->json([
                "backups" => $backupsPaginated,
                "overallInformation" => $overallInformation
            ], 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }

    }

    private function checkDiskHealth(string $disk): string
    {
        // Check if the disk is reachable
        if (Storage::disk($disk)->exists('/')) {
            $freeSpace = disk_free_space(Storage::disk($disk)->path('/'));
            $totalSpace = disk_total_space(Storage::disk($disk)->path('/'));

            $thresholdPercentage = 10;

            $freeSpacePercentage = ($freeSpace / $totalSpace) * 100;

            return ($freeSpacePercentage >= $thresholdPercentage) ? 'Healthy' : 'Not Healthy';
        }

        return 'Not Reachable';
    }

    public function destroy(string $file): Response
    {
        try {
            $filePath = env("APP_NAME").'/'.$file;

            Storage::disk('local')->delete($filePath);

            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function backup(): JsonResponse
    {
        try {
            Artisan::call('backup:run');

            return response()->json(["message" => "Backup completed successfully"], 200);

        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function download(string $file): JsonResponse|BinaryFileResponse
    {
        $filePath = env("APP_NAME").'/'.$file;

        try {
            if (Storage::disk('local')->exists($filePath)) {
                return response()->download(storage_path("app/{$filePath}"), $file, [
                    'Content-Type' => 'application/zip',
                    'Content-Disposition' => 'attachment; filename='.$file,
                ]);
            } else {
                return response()->json(["message" => "Backup File not found!"], 500);
            }
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
