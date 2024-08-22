<?php
/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

    function getRoleNameById($id)
    {
        $roleModel = new \App\Models\Roles();
        $role = $roleModel->find($id);

        return $role ? $role['name'] : null;
    }

    function getCourseNameById($id)
    {
        $courseModel = new \App\Models\Course();
        $course = $courseModel->find($id);

        return $course ? $course['name'] : null;
    }

    function getSchoolNameById($id)
    {
        $schoolModel = new \App\Models\School();
        $school = $schoolModel->find($id);

        return $school ? $school['name'] : null;
    }

    function getUsernameById($id)
    {
        $userModel = new \App\Models\User();
        $user = $userModel->find($id);

        return $user ? $user['full_name'] : null;
    }
 

use App\Models\Logs;

if (!function_exists('log_action')) {
    function log_action($userId, $message)
    {
        $logModel = new Logs();
        $logData = [
            'user_id' => $userId,
            'action' => $message,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $logModel->insert($logData);
    }
}
