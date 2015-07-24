<?php

namespace App\Tools\API\Transformers;

use App\Models\User;
use Auth;

/**
 * Class TaskTransformer
 * @package App\Tools\Transformers
 */
class TaskTransformer extends Transformer {

    /**
     * @param $task
     * @return array
     */
    public function transform($task) {
        $assignee_id = null;
        if ($task['assignee_id'] != 0)
            $assignee_id = User::find($task['assignee_id'])['displayname'];

        return [
            'id' => $task['id'],
            'title' => $task['title'],
            'content' => $task['content'],
            'creator' => User::find($task['creator'])['displayname'],
            'assignee_id' => $assignee_id,
            'public' => (boolean)$task['public'],
            'completed' => (boolean)$task['status']
        ];
    }

}