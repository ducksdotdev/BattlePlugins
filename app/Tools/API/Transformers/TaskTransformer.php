<?php

namespace App\Tools\API\Transformers;

use App\Tools\Models\User;
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
        $assigned_to = null;
        if ($task['assigned_to'] != 0)
            $assigned_to = User::find($task['assigned_to'])['displayname'];

        return [
            'id' => $task['id'],
            'title' => $task['title'],
            'content' => $task['content'],
            'creator' => User::find($task['creator'])['displayname'],
            'assigned_to' => $assigned_to,
            'public' => (boolean)$task['public'],
            'completed' => (boolean)$task['status']
        ];
    }

}