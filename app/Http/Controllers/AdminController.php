<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Admin;
use App\Models\Project;
use App\Models\Evaluator;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\DeclinedProject;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $unassignedProjects = Project::whereDoesntHave('assignment')
            ->get();

        $awaitingConsentProjects = Assignment::where('status', 'awaiting_consent')
            ->with('project')
            ->get();

        $assignedProjects = Assignment::where('status', 'assigned')
            ->with('project')
            ->get();

        $evaluationCompleteProjects = Assignment::where('status', 'completed')
            ->with('project')
            ->get();

        $completedProjects = Assignment::where('status', 'admin_complete')
            ->with('project')
            ->get();

        $domain =Domain::where('status',1)->get();
        
        return view('admindashboard', compact('unassignedProjects', 'awaitingConsentProjects', 'assignedProjects', 'evaluationCompleteProjects', 'completedProjects','domain'));
    }

    public function showDomain(){
        $domain =Domain::all();
        $domaineval =Domain::where('status',1)->get();
        return view('domain', compact('domain', 'domaineval' ));
    }

    public function saveDomain(Request $request){
        
        $request->validate([
            'name' => 'required|unique:domains,name',
        ]);

        $domain = new Domain();
        $domain->name = $request->name;
        $domain->status = 1;
        $domain->save();

        return redirect()->route('admin.showDomain')->with('success', 'Domain added successfully!');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function assignEvaluator(Request $request, $projectId)
    {
        
        $project = Project::findOrFail($projectId);
        $domain = $project->domain->id;

        // Fetch evaluators whose domain matches with the project's domain
        $evaluators = Evaluator::where('domain_id', $domain)->get();

        // Fetch declined evaluators for the project with their decline timestamps
        $declinedEvaluators = DeclinedProject::where('project_id', $projectId)
            ->join('evaluators', 'declined_projects.evaluator_id', '=', 'evaluators.id')
            ->select('evaluators.*', 'declined_projects.created_at as declined_at')
            ->get();

        return view('assign_evaluator', compact('project', 'evaluators', 'declinedEvaluators'));
    }

    public function assignEvaluatorSearch(Request $request, $projectId)
    {
        // dd($request,$projectId);
        $keyword = $request->input('search');

        $project = Project::findOrFail($projectId);
        $domain= $project->domain->id;

        // Fetch evaluators whose domain matches with the project's domain
        $evaluatorsQuery = Evaluator::where('domain_id', $domain);

        // Fetch declined evaluators for the project with their decline timestamps
        $declinedEvaluators = DeclinedProject::where('project_id', $projectId)
            ->join('evaluators', 'declined_projects.evaluator_id', '=', 'evaluators.id')
            ->select('evaluators.*', 'declined_projects.created_at as declined_at')
            ->get();

            if ($keyword) {
                $evaluatorsQuery = Evaluator::where('domain_id', $domain)
                    ->where('name', 'LIKE', "%{$keyword}%");
            }
            
        $evaluators=$evaluatorsQuery->get();
        return view('assign_evaluator', compact('project', 'evaluators', 'declinedEvaluators'));
    }

    
    public function submitEvaluatorAssignment(Request $request, $projectId)
    {
        $evaluatorId = $request->input('evaluator_id');

        // Create a new assignment
        $assignment = new Assignment();
        $assignment->project_id = $projectId;
        $assignment->evaluator_id = $evaluatorId;
        $assignment->status = 'awaiting_consent';
        $assignment->save();

        return redirect()->route('admin.dashboard')->with('success', 'Evaluator assigned successfully.');
    }
    
    public function submitAdminComments(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        $assignment->admin_comments = $request->input('admin_comments');
        $assignment->admin_remarks = $request->input('admin_remarks');
        
        $adminRemarks = $request->input('admin_remarks');
    
        if ($adminRemarks === 'Modify') {
            $assignment->status = 'Modify';
        } else {
            $assignment->status = 'admin_complete';
        }
        
        $assignment->save();
    
        return redirect()->route('admin.dashboard')->with('success', 'Admin comments submitted successfully.');
    } 
    public function search(Request $request)
{
    $keyword = $request->input('search');

    $unassignedProjectsQuery = Project::whereDoesntHave('assignment');
    $awaitingConsentProjectsQuery = Assignment::where('status', 'awaiting_consent')->with('project');
    $assignedProjectsQuery = Assignment::where('status', 'assigned')->with('project');
    $evaluationCompleteProjectsQuery = Assignment::where('status', 'completed')->with('project');
    $completedProjectsQuery = Assignment::where('status', 'admin_complete')->with('project');

    if ($keyword) {
        $unassignedProjectsQuery->where('title', 'LIKE', "%{$keyword}%");
        $awaitingConsentProjectsQuery->whereHas('project', function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%{$keyword}%");
        });
        $assignedProjectsQuery->whereHas('project', function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%{$keyword}%");
        });
        $evaluationCompleteProjectsQuery->whereHas('project', function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%{$keyword}%");
        });
        $completedProjectsQuery->whereHas('project', function ($query) use ($keyword) {
            $query->where('title', 'LIKE', "%{$keyword}%");
        });
    }

    $unassignedProjects = $unassignedProjectsQuery->get();
    $awaitingConsentProjects = $awaitingConsentProjectsQuery->get();
    $assignedProjects = $assignedProjectsQuery->get();
    $evaluationCompleteProjects = $evaluationCompleteProjectsQuery->get();
    $completedProjects = $completedProjectsQuery->get();
    $domain =Domain::where('status',1)->get();

    return view('admindashboard', compact('unassignedProjects', 'awaitingConsentProjects', 'assignedProjects', 'evaluationCompleteProjects', 'completedProjects', 'keyword','domain'));
}

    public function toggle(Request $request)
    {
        $domain = Domain::find($request->id);

        if ($domain) {
            $domain->status = $request->dstatus;
            $domain->save();
            return redirect()->route('admin.showDomain')->with('success', 'Domain status updated successfully.');
        }
    }
}


