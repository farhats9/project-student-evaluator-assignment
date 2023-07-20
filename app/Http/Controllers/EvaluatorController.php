<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Evaluator;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\DeclinedProject;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// updated with consent

class EvaluatorController extends Controller
{
    public function dashboard(Request $request)
    {
        // if ($request->has('search')) {
        //     return $this->search($request);
        // }
        $evaluatorId = Auth::guard('evaluator')->id();
        
        $unassignedProjects = Assignment::where('status', 'awaiting_consent')
            ->where('evaluator_id', $evaluatorId)
            ->with('project')
            ->get();

        $assignedProjects = Assignment::where('evaluator_id', $evaluatorId)
            ->where('status', 'assigned')
            ->with('project')
            ->get();

        $completedProjects = Assignment::where('evaluator_id', $evaluatorId)
            ->where('status', 'completed')
            ->with('project')
            ->get();

        $declinedProjects = DeclinedProject::where('evaluator_id', $evaluatorId)
            ->with('project')
            ->get();

        return view('evaluatordashboard', compact('unassignedProjects', 'assignedProjects', 'completedProjects', 'declinedProjects'));
    }

 

    public function viewFile($projectId)
    {
        
       // $project = Project::findOrFail($projectId);
        
        // // Check if the project belongs to the logged-in evaluator

        // if ($project->assignment == NULL) {
        //     abort(403); // Unauthorized access
        // }
        // if ($project->assignment->evaluator_id !== Auth::guard('evaluator')->id()) {
        //     abort(403); // Unauthorized access
        // }
        
        // $filePath = storage_path('app/' . $project->file_upload);
        // dd($filePath);
        
        // if (!file_exists($filePath)) {
        //     abort(404); // File not found
        // }
        
        // //return response()->file($filePath);
        $project = Project::findOrFail($projectId);

        if (!$project->assignment || !$project->file_upload) {
            abort(404);
        }

        $pdfPath = Storage::path($project->file_upload);

        return response()->file($pdfPath, ['Content-Type' => 'application/pdf']);
    }

    public function logout(){
        Auth::guard('evaluator')->logout();
        return redirect('/');
    }

    public function search(Request $request)
    {
        $evaluatorId = Auth::guard('evaluator')->id();
        $search = $request->input('search');

        $unassignedProjects = Assignment::where('status', 'awaiting_consent')
            ->where('evaluator_id', $evaluatorId)
            ->with('project')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('project', function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            })
            ->get();

        $assignedProjects = Assignment::where('evaluator_id', $evaluatorId)
            ->where('status', 'assigned')
            ->with('project')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('project', function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            })
            ->get();

        $completedProjects = Assignment::where('evaluator_id', $evaluatorId)
            ->where('status', 'completed')
            ->with('project')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('project', function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            })
            ->get();

        $declinedProjects = DeclinedProject::where('evaluator_id', $evaluatorId)
            ->with('project')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('project', function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            })
            ->get();

        return view('evaluatordashboard', compact('unassignedProjects', 'assignedProjects', 'completedProjects', 'declinedProjects'));
    }

    public function giveConsent(Request $request, $id)
{
    $assignment = Assignment::find($id);

    if ($assignment) {
        if ($request->input('consent') === 'accept') {
            $assignment->status = 'assigned';
            $assignment->save();
            return redirect()->route('evaluator.dashboard')->with('success', 'Project accepted successfully.');
        } elseif ($request->input('consent') === 'decline') {
            $assignment->delete();

            $declinedProject = new DeclinedProject();
            $declinedProject->project_id = $assignment->project_id;
            $declinedProject->evaluator_id = $assignment->evaluator_id;
            $declinedProject->save();

            return redirect()->route('evaluator.dashboard')->with('success', 'Project declined successfully.');
        }
    }

    return redirect()->route('evaluator.dashboard')->with('error', 'Assignment not found.');
}

public function submitComments(Request $request,$id)
    {
        $request->validate([
            'evaluator_comments' => 'required',
            'evaluator_remarks' => 'required'
        ]);

        $assignment = Assignment::find($id);

        if ($assignment) {
            $assignment->evaluator_comments = $request->evaluator_comments;
            $assignment->evaluator_remarks = $request->evaluator_remarks;
            $assignment->status = 'completed';
            $assignment->save();
            
            return redirect()->route('evaluator.dashboard')->with('success', 'Comments submitted successfully.');
        } else {
            return redirect()->route('evaluator.dashboard')->with('error', 'Assignment not found.');
        }
    }
    
}