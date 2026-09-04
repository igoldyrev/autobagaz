<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\User;

class AdminActivityLogger
{
    public function record(
        User $actor,
        string $action,
        string $description,
        ?string $subjectType = null,
        ?int $subjectId = null,
        ?string $subjectName = null,
    ): AdminActivityLog {
        return AdminActivityLog::query()->create([
            'user_id' => $actor->id,
            'user_name' => $actor->name,
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'subject_name' => $subjectName,
            'description' => $description,
        ]);
    }
}
