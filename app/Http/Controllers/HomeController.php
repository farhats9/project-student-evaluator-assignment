<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Domain;
use App\Models\Student;
use App\Models\Evaluator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){
        $domain =Domain::where('status',1)->get();
        return view('home', ['domain' => $domain]);
    }
    
    public function login(Request $request)
    {
        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:admin,evaluator,student',
        ]);

        // Extract the role from the validated data
        
        $role = $validatedData['role'];

        // Perform login authentication based on the user's role
        switch ($role) {
            case 'admin':
                if (Auth::guard('admin')->attempt(['email' => $validatedData['name'], 'password' => $validatedData['password']])) {
                    // Authentication passed for admin user
                    return redirect()->route('admin.dashboard');
                } else {
                    // Authentication failed for admin user
                    return redirect()->back()->withErrors(['loginfailed' => 'Invalid credentials']);
                }

            case 'evaluator':
                if (Auth::guard('evaluator')->attempt(['email' => $validatedData['name'], 'password' => $validatedData['password']])) {
                    // Authentication passed for reviewer user
                    return redirect()->route('evaluator.dashboard');
                } else {
                    // Authentication failed for reviewer user
                    return redirect()->back()->withErrors(['loginfailed' => 'Invalid credentials']);
                }

            case 'student':
                if (Auth::guard('student')->attempt(['email' => $validatedData['name'], 'password' => $validatedData['password']])) {
                    // Authentication passed for student user
                    return redirect()->route('student.dashboard');
                } else {
                    // Authentication failed for student user
                    return redirect()->back()->withErrors(['loginfailed' => 'Invalid credentials']);
                }
        }
    }

    public function register(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string',
        'confirmPassword'=> 'required|same:password',
        'role' => 'required|in:admin,evaluator,student',
    ]);

    // Extract the role from the validated data
    $role = $validatedData['role'];

    // Check uniqueness based on the user's role
    switch ($role) {
        case 'admin':
            $adminEmailExists = Admin::where('email', $validatedData['email'])->exists();
            if ($adminEmailExists) {
                return redirect()->back()->withErrors(['email' => 'Email already exists']);
            }

            $admin = Admin::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            return redirect()->route('home')->with('success', 'Admin account created Successfully');

        case 'evaluator':
            $evaluatorEmailExists = Evaluator::where('email', $validatedData['email'])->exists();
            if ($evaluatorEmailExists) {
                return redirect()->back()->withErrors(['email' => 'Email already exists']);
            }

            $reviewer = Evaluator::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'domain_id' => $request->input('domain_id'),
            ]);

            return redirect()->route('home')->with('success', 'Evaluator account created Successfully');

        case 'student':
            $studentEmailExists = Student::where('email', $validatedData['email'])->exists();
            if ($studentEmailExists) {
                return redirect()->back()->withErrors(['email' => 'Email already exists']);
            }

            $student = Student::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            return redirect()->route('home')->with('success', 'Student account created Successfully');
    }
}

    public function evalregister(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:evaluators',
            'password' => 'required|string',
            'confirmPassword'=> 'required|same:password',
            'role' => 'required|in:admin,evaluator,student',
        ]);

        $reviewer = Evaluator::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'domain_id' => $request->input('domain_id'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Evaluator account added Successfully');

    }
}
