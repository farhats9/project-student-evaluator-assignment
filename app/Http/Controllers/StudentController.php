<?php

namespace App\Http\Controllers;


use App\Models\Domain;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class StudentController extends Controller
{

    public function dashboard()
    {
        $domain =Domain::where('status',1)->get();
        return view('submission',compact('domain'));
    }

    public function logout(){
        Auth::guard('student')->logout();
        return redirect('/');
    }

    public function save(Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required',
            'abstract' =>'required',
            'keywords' => 'required',
            'domain_id'=>'required',
            'docType'=> 'required',
            'report'=>'required'
        ]);
        
        $incomingFields['student_id']=Auth::guard('student')->id();
        $filename = time()."__.".$request->file('report')->getClientOriginalExtension();
        $pathh= $request->file('report')->storeAs('public/uploads',$filename);
        $incomingFields['file_upload'] = $pathh;
        
        Project::create($incomingFields);
        return redirect('/student/dashboard')->with('success', 'Submitted Successfully!');
    }

    public function mySubmission()
    {
        $studentId = Auth::guard('student')->id();
        
        // Get projects that are not yet evaluated or have a status other than 'admin_complete'
        $notEvaluatedProjects = Project::where(function ($query) use ($studentId) {
            $query->whereDoesntHave('assignment')
                ->orWhereHas('assignment', function ($query) {
                    $query->where('status', '!=', 'admin_complete')
                        ->where('status', '!=', 'Modify');
                });
        })
        ->where('student_id', $studentId)
        ->get();

        
        
        // Get projects that have been evaluated
        $evaluatedProjects = Project::Where('student_id', $studentId)
            ->whereHas('assignment', function ($query) {
                $query->where('status','admin_complete');
            })
            ->get();
        
        // Get projects that have a status of 'modify'
        $modifiedProjects = Project::where('student_id', $studentId)
        ->whereHas('assignment', function ($query) {
            $query->where('status', 'Modify');
        })
        ->get();
        
        return view('mysubmission', compact('notEvaluatedProjects', 'evaluatedProjects','modifiedProjects'));
    }

    public function resubmit(Request $request, $id)
{
    $project = Project::findOrFail($id);

    if ($request->hasFile('report')) {
        // Delete the old PDF file if it exists
        if ($project->file_upload && Storage::exists($project->file_upload)) {
            Storage::delete($project->file_upload);
        }

        // Store the new PDF file using the same logic as the original submission
        $filename = time() . "__." . $request->file('report')->getClientOriginalExtension();
        $path = $request->file('report')->storeAs('public/uploads', $filename);

        // Update the PDF file path in the project
        $project->file_upload = $path;
    }

    $project->save();

    // Update the assignment status to 'assigned'
    if ($project->assignment) {
        $project->assignment->status = 'assigned';
        $project->assignment->admin_comments = NULL;
        $project->assignment->admin_remarks = NULL;
        $project->assignment->evaluator_comments = NULL;
        $project->assignment->evaluator_remarks = NULL;
        $project->assignment->save();
    }

    return redirect()->route('student.dashboard')->with('success', 'PDF file resubmitted successfully.');
}

}
