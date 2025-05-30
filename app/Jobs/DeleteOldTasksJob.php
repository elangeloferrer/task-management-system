<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;

use App\AuditTrail\AuditActivityLog;

use App\Models\Task;

class DeleteOldTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        try {
            $cutoffDate = Carbon::now()->subDays(30);
            $oldTasks = Task::where('created_at', '<', $cutoffDate)->get();

            if (count($oldTasks) > 0) {
                Log::info('START: DELETING OLD TASKS');

                $jsonString = $oldTasks->toJson();
                $oldTaskIds = $oldTasks->pluck('id');

                Task::whereIn('id', $oldTaskIds)->delete();
                Log::info('DELETED TASKS COUNT: ' . $oldTaskIds->count());

                $payload = [
                    'action' => "delete",
                    'description' => "Delete tasks older than 30 days",
                    'old_data' => $jsonString,
                ];

                $auditLog = app(AuditActivityLog::class);
                $auditLog->setPayload($payload)->call();

                Log::info('END: DELETING OLD TASKS');
            } else {
                Log::info('NO OLD TASKS FOUND FOR DELETION.');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
