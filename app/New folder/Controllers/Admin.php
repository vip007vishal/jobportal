<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\JobModel;
use App\Models\ApplicationModel;
use App\Models\ApplicationLogModel;
use App\Models\SkillModel;

class Admin extends BaseController
{
    public function login()
    {
        $session = session();

        $model = new UserModel();

        $email = $this->request->getPost('email');

        $password = $this->request->getPost('password');

        $user = $model
            ->where('email', $email)
            ->first();

        if (!$user) {

            return redirect()
                ->back()
                ->with('error', 'Invalid Email');
        }

        if ($user['status'] != 'active') {

            return redirect()
                ->back()
                ->with('error', 'Access Revoked');
        }

        if (!password_verify($password, $user['password'])) {

            return redirect()
                ->back()
                ->with('error', 'Invalid Password');
        }

        $session->set([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_role' => $user['role'],
            'logged_in' => true
        ]);

        return redirect()->to(base_url('admin/dashboard'));
    }

    public function dashboard()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        $skillModel = new SkillModel();

        $allSkills = $skillModel->findAll();

        $data['allSkills'] = $allSkills;

        $applicationModel = new ApplicationModel();

        $jobModel = new JobModel();

        $skillModel = new SkillModel();

        $allSkills = $skillModel->findAll();

        $search = $this->request->getGet('search');

        $status = $this->request->getGet('status');

        $builder = $applicationModel
            ->select('
                applications.*,
                job_roles.role_name,
                job_roles.technical_skills,
                users.name as assigned_user_name,
                users.role as assigned_user_role
            ')
            ->join(
                'job_roles',
                'job_roles.id = applications.role_id'
            );

        $builder->join(
            'users',
            'users.id = applications.assigned_user_id',
            'left'
        );

        if (session()->get('user_role') != 'admin') {

            $builder->where(
                'applications.assigned_user_id',
                session()->get('user_id')
            );
        }

        if ($search) {

            $builder->groupStart()
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('mobile', $search)
                ->orLike('role_name', $search)
                ->groupEnd();
        }

        if ($status) {

            $builder->where(
                'applications.status',
                $status
            );
        }

        $applications = $builder
            ->orderBy('applications.id', 'DESC')
            ->findAll();

        foreach ($applications as &$application) {

            $jobSkills = [];

            $candidateSkills = [];

            if (!empty($application['technical_skills'])) {

                $jobSkills = array_map(
                    'trim',
                    explode(
                        ',',
                        strtolower($application['technical_skills'])
                    )
                );
            }

            if (!empty($application['skills_summary'])) {

                $candidateSkills = array_map(
                    'trim',
                    explode(
                        ',',
                        strtolower($application['skills_summary'])
                    )
                );
            }

            if (count($jobSkills) > 0) {

                $matchedSkills = array_intersect(
                    $jobSkills,
                    $candidateSkills
                );

                $percentage = (
                    count($matchedSkills)
                    /
                    count($jobSkills)
                ) * 100;

                $application['skill_match'] = round($percentage);
            } else {

                $application['skill_match'] = 0;
            }
        }

        $jobs = $jobModel->findAll();

        $statusCounts = [
            'Applied' => 0,
            'Waiting' => 0,
            'Hired' => 0,
            'Rejected' => 0,
            'Hold' => 0
        ];

        foreach ($applications as $app) {

            if (isset($statusCounts[$app['status']])) {

                $statusCounts[$app['status']]++;
            }
        }

        $roleCounts = [];

        foreach ($applications as $app) {

            $role = $app['role_name'];

            if (!isset($roleCounts[$role])) {

                $roleCounts[$role] = 0;
            }

            $roleCounts[$role]++;
        }

        $data['applications'] = $applications;

        $data['jobs'] = $jobs;

        $data['allSkills'] = $allSkills;

        $data['statusCounts'] = $statusCounts;

        $data['roleCounts'] = $roleCounts;

        $data['userRole'] = session()->get('user_role');

        return view(
            'admin/dashboard',
            $data
        );
    }

    public function addRole()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (session()->get('user_role') != 'admin') {

            return redirect()->back();
        }

        $jobModel = new JobModel();

        $roleName = $this->request->getPost('role_name');

        $description = $this->request->getPost('description');

        $status = $this->request->getPost('status');

        // checkbox skills
        $requiredSkills = $this->request->getPost('required_skills');

        // convert array to comma separated string
        $technicalSkills = '';

        if (!empty($requiredSkills)) {

            $technicalSkills = implode(',', $requiredSkills);
        }

        $jobModel->save([

            'role_name' => $roleName,

            'description' => $description,

            'technical_skills' => $technicalSkills,

            'status' => $status
        ]);

        return redirect()->to(base_url('admin/dashboard'));
    }

    public function assignApplication()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (session()->get('user_role') != 'admin') {

            return redirect()->back();
        }

        $applicationId = $this->request->getPost('application_id');

        $userId = $this->request->getPost('user_id');

        $applicationModel = new ApplicationModel();

        $userModel = new UserModel();

        $user = $userModel->find($userId);

        if (!$user) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        if (
            $user['role'] != 'hr' &&
            $user['role'] != 'tl'
        ) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid role'
            ]);
        }

        $applicationModel->update($applicationId, [
            'assigned_user_id' => $userId
        ]);

        $logModel = new ApplicationLogModel();

        $logModel->save([
            'application_id' => $applicationId,
            'user_id' => session()->get('user_id'),
            'action' => 'application_assigned',
            'description' => 'Assigned to ' . $user['name']
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Application Assigned'
        ]);
    }


    public function getAssignableUsers()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (session()->get('user_role') != 'admin') {

            return redirect()->back();
        }

        $userModel = new UserModel();

        $users = $userModel
            ->whereIn('role', ['hr', 'tl'])
            ->where('status', 'active')
            ->findAll();

        return $this->response->setJSON($users);
    }

    public function updateStatus($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        $applicationModel = new ApplicationModel();

        $status = $this->request->getPost('status');

        $application = $applicationModel
            ->select('
        applications.*,
        job_roles.role_name,
        job_roles.technical_skills,
        users.name as assigned_user_name,
        users.role as assigned_user_role
    ')
            ->join(
                'job_roles',
                'job_roles.id = applications.role_id'
            )
            ->join(
                'users',
                'users.id = applications.assigned_user_id',
                'left'
            )
            ->where(
                'applications.id',
                $id
            )
            ->first();

        if (
            session()->get('user_role') != 'admin' &&
            $application['assigned_user_id'] != session()->get('user_id')
        ) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $applicationModel->update($id, [
            'status' => $status
        ]);

        $logModel = new ApplicationLogModel();

        $logModel->save([
            'application_id' => $id,
            'user_id' => session()->get('user_id'),
            'action' => 'status_updated',
            'description' => 'Status changed to ' . $status
        ]);

        $email = \Config\Services::email();

        $email->setFrom(
            'vishal15v2006@gmail.com',
            'Job Portal'
        );

        $email->setTo(
            $application['email']
        );

        $email->setSubject(
            'Application Status Updated'
        );

        $message = '';

        if ($status == 'Hired') {

            $message = "
                <h2>Congratulations!</h2>
                <p>You have been hired.</p>
            ";
        } elseif ($status == 'Rejected') {

            $message = "
                <h2>Application Rejected</h2>
                <p>Unfortunately you were not selected.</p>
            ";
        } elseif ($status == 'Waiting') {

            $message = "
                <h2>Application Waiting</h2>
                <p>Your application is under review.</p>
            ";
        } else {

            $message = "
                <h2>Application On Hold</h2>
                <p>Your application is currently on hold.</p>
            ";
        }

        $email->setMessage($message);

        $email->send();

        $logModel->save([
            'application_id' => $id,
            'user_id' => session()->get('user_id'),
            'action' => 'email_sent',
            'description' => 'Status email sent to applicant'
        ]);

        return $this->response->setJSON([
            'success' => true,
            'status' => $status
        ]);
    }

    public function applicationLogs($applicationId)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        $logModel = new ApplicationLogModel();

        $logs = $logModel
            ->select('
            application_logs.*,
            users.name as user_name,
            users.role as user_role
        ')
            ->join(
                'users',
                'users.id = application_logs.user_id',
                'left'
            )
            ->where(
                'application_logs.application_id',
                $applicationId
            )
            ->orderBy(
                'application_logs.id',
                'DESC'
            )
            ->findAll();

        return $this->response->setJSON($logs);
    }

    public function users()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (session()->get('user_role') != 'admin') {

            return redirect()->back();
        }

        $userModel = new UserModel();

        $users = $userModel
            ->whereIn('role', ['hr', 'tl'])
            ->findAll();

        return $this->response->setJSON($users);
    }

    public function createUser()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (session()->get('user_role') != 'admin') {

            return redirect()->back();
        }

        $userModel = new UserModel();

        $name = $this->request->getPost('name');

        $email = $this->request->getPost('email');

        $password = $this->request->getPost('password');

        $role = $this->request->getPost('role');

        if (
            $role != 'hr' &&
            $role != 'tl'
        ) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Role'
            ]);
        }

        $existing = $userModel
            ->where('email', $email)
            ->first();

        if ($existing) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email Already Exists'
            ]);
        }

        $userModel->save([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'status' => 'active'
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'User Created'
        ]);
    }

    public function updateUserStatus($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (session()->get('user_role') != 'admin') {

            return redirect()->back();
        }

        $userModel = new UserModel();

        $user = $userModel->find($id);

        if (!$user) {

            return $this->response->setJSON([
                'success' => false,
                'message' => 'User Not Found'
            ]);
        }

        $newStatus = $user['status'] == 'active'
            ? 'inactive'
            : 'active';

        $userModel->update($id, [
            'status' => $newStatus
        ]);

        return $this->response->setJSON([
            'success' => true,
            'status' => $newStatus
        ]);
    }

    public function applicantDetails($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        $applicationModel = new ApplicationModel();

        $application = $applicationModel->find($id);

        if (!$application) {

            return redirect()->back();
        }

        if (
            session()->get('user_role') != 'admin' &&
            $application['assigned_user_id'] != session()->get('user_id')
        ) {

            return redirect()->back();
        }

        if (session()->get('user_role') == 'tl') {

            unset($application['mobile']);

            unset($application['address']);

            unset($application['email']);

            unset($application['nationality']);

            unset($application['dob']);
        }

        $data['application'] = $application;

        $logModel = new ApplicationLogModel();

        $jobSkills = [];

        $candidateSkills = [];

        if (!empty($application['technical_skills'])) {

            $jobSkills = array_map(
                'trim',
                explode(
                    ',',
                    strtolower($application['technical_skills'])
                )
            );
        }

        if (!empty($application['skills_summary'])) {

            $candidateSkills = array_map(
                'trim',
                explode(
                    ',',
                    strtolower($application['skills_summary'])
                )
            );
        }

        if (count($jobSkills) > 0) {

            $matchedSkills = array_intersect(
                $jobSkills,
                $candidateSkills
            );

            $percentage = (
                count($matchedSkills)
                /
                count($jobSkills)
            ) * 100;

            $data['skillMatch'] = round($percentage);
        } else {

            $data['skillMatch'] = 0;
        }

        $data['logs'] = $logModel
            ->select('
        application_logs.*,
        users.name as user_name,
        users.role as user_role
    ')
            ->join(
                'users',
                'users.id = application_logs.user_id',
                'left'
            )
            ->where(
                'application_logs.application_id',
                $id
            )
            ->orderBy(
                'application_logs.id',
                'DESC'
            )
            ->findAll();

        $data['userRole'] = session()->get('user_role');

        return view(
            'admin/applicant_details',
            $data
        );
    }

    public function technicalReview($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (
            session()->get('user_role') != 'tl' &&
            session()->get('user_role') != 'admin'
        ) {

            return redirect()->back();
        }

        $applicationModel = new ApplicationModel();

        $application = $applicationModel->find($id);

        if (!$application) {

            return redirect()->back();
        }

        if (
            session()->get('user_role') != 'admin' &&
            $application['assigned_user_id'] != session()->get('user_id')
        ) {

            return redirect()->back();
        }

        $review = $this->request->getPost('technical_review');

        $rating = $this->request->getPost('technical_rating');

        $recommendation = $this->request->getPost('technical_recommendation');

        $applicationModel->update($id, [
            'technical_review' => $review,
            'technical_rating' => $rating,
            'technical_recommendation' => $recommendation
        ]);

        $logModel = new ApplicationLogModel();

        $logModel->save([
            'application_id' => $id,
            'user_id' => session()->get('user_id'),
            'action' => 'technical_review_added',
            'description' => 'Technical review submitted'
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Technical Review Added'
        ]);
    }

    public function scheduleInterview($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        if (
            session()->get('user_role') != 'admin' &&
            session()->get('user_role') != 'hr'
        ) {

            return redirect()->back();
        }

        $applicationModel = new ApplicationModel();

        $application = $applicationModel->find($id);

        if (!$application) {

            return redirect()->back();
        }

        if (
            session()->get('user_role') != 'admin' &&
            $application['assigned_user_id'] != session()->get('user_id')
        ) {

            return redirect()->back();
        }

        $interviewDate = $this->request->getPost('interview_date');

        $interviewMode = $this->request->getPost('interview_mode');

        $interviewLink = $this->request->getPost('interview_link');

        $interviewerNotes = $this->request->getPost('interviewer_notes');

        $applicationModel->update($id, [

            'interview_date' => $interviewDate,

            'interview_mode' => $interviewMode,

            'interview_link' => $interviewLink,

            'interview_status' => 'Scheduled',

            'interviewer_notes' => $interviewerNotes
        ]);

        $logModel = new ApplicationLogModel();

        $logModel->save([

            'application_id' => $id,

            'user_id' => session()->get('user_id'),

            'action' => 'interview_scheduled',

            'description' => 'Interview scheduled'
        ]);

        return $this->response->setJSON([

            'success' => true,

            'message' => 'Interview Scheduled'
        ]);
    }

    public function applicationTimeline($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/');
        }

        $applicationModel = new ApplicationModel();

        $application = $applicationModel->find($id);

        if (!$application) {

            return redirect()->back();
        }

        if (
            session()->get('user_role') != 'admin' &&
            $application['assigned_user_id'] != session()->get('user_id')
        ) {

            return redirect()->back();
        }

        $logModel = new ApplicationLogModel();

        $logs = $logModel
            ->select('
            application_logs.*,
            users.name as user_name,
            users.role as user_role
        ')
            ->join(
                'users',
                'users.id = application_logs.user_id',
                'left'
            )
            ->where(
                'application_logs.application_id',
                $id
            )
            ->orderBy(
                'application_logs.created_at',
                'DESC'
            )
            ->findAll();

        $timeline = [];

        foreach ($logs as $log) {

            $timeline[] = [

                'type' => 'log',

                'action' => $log['action'],

                'description' => $log['description'],

                'user_name' => $log['user_name'],

                'user_role' => $log['user_role'],

                'created_at' => $log['created_at']
            ];
        }

        if (!empty($application['technical_review'])) {

            $timeline[] = [

                'type' => 'technical_review',

                'action' => 'Technical Review',

                'description' => $application['technical_review'],

                'user_name' => 'TL/Admin',

                'user_role' => 'Reviewer',

                'created_at' => $application['created_at']
            ];
        }

        if (!empty($application['interview_date'])) {

            $timeline[] = [

                'type' => 'interview',

                'action' => 'Interview Scheduled',

                'description' => 'Interview on ' . $application['interview_date'],

                'user_name' => 'HR/Admin',

                'user_role' => 'Interviewer',

                'created_at' => $application['interview_date']
            ];
        }

        usort($timeline, function ($a, $b) {

            return strtotime($b['created_at'])
                -
                strtotime($a['created_at']);
        });

        return $this->response->setJSON($timeline);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}
