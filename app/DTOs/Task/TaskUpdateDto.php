<?php

namespace App\DTOs\Task;

use App\Enums\TaskStatus;
use App\Http\Requests\TaskDataRequest;

final class TaskUpdateDto {
    public function __construct(
        public string $title,
        public string $status,
        public string $due_date = '',
        public string $description = '',
    )
    {}

    public static function FromRequest(TaskDataRequest $request) {
        return new self(...$request->validated());
    }

    public function toArray() {
        $data = [
            'title' => $this->title,
            'status' => $this->status,
        ];

        if ($this->due_date != '') {
            $data['due_date'] = $this->due_date;
        }
        if ($this->description != '') {
            $data['description'] = $this->description;
        }

        return $data;
    }
}