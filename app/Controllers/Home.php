<?php

namespace App\Controllers;

use App\Models\JobModel;
use App\Models\ApplicationModel;
use App\Models\ApplicationLogModel;
use App\Models\SkillModel;

class Home extends BaseController
{
    public function index()
    {
        $jobModel = new JobModel();

        $skillModel = new SkillModel();

        $data['jobs'] = $jobModel
            ->where('status', 'open')
            ->findAll();

        $data['allSkills'] = $skillModel
            ->findAll();

        return view('home', $data);
    }

    public function loginPage()
    {
        return view('admin-login');
    }

    public function apply()
    {
        $applicationModel = new ApplicationModel();


        $emailExists = $applicationModel

            ->where(
                'email',
                $this->request->getPost('email')
            )

            ->first();

        if ($emailExists) {

            return redirect()

                ->back()

                ->withInput()

                ->with(
                    'error',
                    'Email is already registered for an application'
                );
        }

        $resume = $this->request->getFile('resume');

        if (!$resume->isValid()) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Resume Upload Failed'
                );
        }

        $resumeName = $resume->getRandomName();

        $resume->move(
            'uploads/resumes',
            $resumeName
        );

        $technicalSkills = $this->request->getPost('technical_skills');

        if ($technicalSkills) {

            $technicalSkills = implode(
                ', ',
                $technicalSkills
            );
        } else {

            $technicalSkills = '';
        }

        $data = [

            /*
            |--------------------------------------------------------------------------
            | STEP 1
            |--------------------------------------------------------------------------
            */

            'full_name' => $this->request->getPost('full_name'),

            'email' => $this->request->getPost('email'),

            'mobile' => $this->request->getPost('mobile'),

            'dob' => $this->request->getPost('dob'),

            'gender' => $this->request->getPost('gender'),

            'address' => $this->request->getPost('address'),

            'nationality' => $this->request->getPost('nationality'),

            'relocate' => $this->request->getPost('relocate'),

            /*
            |--------------------------------------------------------------------------
            | STEP 2
            |--------------------------------------------------------------------------
            */

            'qualification' => $this->request->getPost('qualification'),

            'institution' => $this->request->getPost('institution'),

            'graduation_year' => $this->request->getPost('graduation_year'),

            'cgpa' => $this->request->getPost('cgpa'),

            'technical_skills' => $technicalSkills,

            'certifications' => $this->request->getPost('certifications'),

            /*
            |--------------------------------------------------------------------------
            | STEP 3
            |--------------------------------------------------------------------------
            */

            'role_id' => $this->request->getPost('role_id'),

            'work_experience' => $this->request->getPost('work_experience'),

            'employment_status' => $this->request->getPost('employment_status'),

            'previous_organization' => $this->request->getPost('previous_organization'),

            'job_title' => $this->request->getPost('job_title'),

            'skills_summary' => $this->request->getPost('skills_summary'),

            'resume' => $resumeName,

            'declaration_accept' => $this->request->getPost('declaration_accept'),

            /*
            |--------------------------------------------------------------------------
            | SYSTEM
            |--------------------------------------------------------------------------
            */

            'status' => 'Applied'
        ];

        $insert = $applicationModel->insert($data);

        if (!$insert) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Database Insert Failed'
                );
        }

        $applicationId = $applicationModel->getInsertID();

        $logModel = new ApplicationLogModel();

        $logModel->save([
            'application_id' => $applicationId,
            'user_id' => null,
            'action' => 'application_created',
            'description' => 'Candidate submitted application'
        ]);

        /*
        |--------------------------------------------------------------------------
        | APPLICANT MAIL
        |--------------------------------------------------------------------------
        */

        $email = \Config\Services::email();

        $email->setFrom(
            'vishal15v2006@gmail.com',
            'Job Portal'
        );

        $email->setTo(
            $this->request->getPost('email')
        );

        $email->setSubject(
            'Application Submitted Successfully'
        );

        $email->setMessage("

            <h2>Application Submitted</h2>

            <p>Hello "
            . $this->request->getPost('full_name') .
            ",</p>

            <p>Your application has been submitted successfully.</p>

            <p>We will contact you soon.</p>

        ");

        $email->send();

        /*
        |--------------------------------------------------------------------------
        | ADMIN MAIL
        |--------------------------------------------------------------------------
        */

        $adminEmail = \Config\Services::email();

        $adminEmail->setFrom(
            'vishal15v2006@gmail.com',
            'Job Portal'
        );

        $adminEmail->setTo(
            'vishal15v2006@gmail.com'
        );

        $adminEmail->setSubject(
            'New Applicant Applied'
        );

        $adminEmail->setMessage("

            <h2>New Application Received</h2>

            <p><strong>Name:</strong> "
            . $this->request->getPost('full_name') .
            "</p>

            <p><strong>Email:</strong> "
            . $this->request->getPost('email') .
            "</p>

            <p><strong>Mobile:</strong> "
            . $this->request->getPost('mobile') .
            "</p>

            <p><strong>Qualification:</strong> "
            . $this->request->getPost('qualification') .
            "</p>

        ");

        $adminEmail->send();



        return redirect()
            ->to('/')
            ->with(
                'success',
                'Application Submitted Successfully'
            );
    }
}
