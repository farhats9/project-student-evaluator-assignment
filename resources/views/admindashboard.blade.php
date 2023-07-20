<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
	<title>Reviewer Login</title>
	<meta name="description" content="">  
	<meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!--CSS & Bootstrap-->
  <link rel="stylesheet" href="{{url('frontend/css/style.css')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body>

    <div class="container-fluid">
        <header>
            <nav class="navbar fixed-top navbar-expand-lg bg-light border-bottom border-bottom-dark" data-bs-theme="light" >
              <div class="container-fluid">
                <a class="navbar-brand" href="/"><img src="{{url('frontend/images/logo.gif')}}" alt="" height="50px" width="50px"> NIT RAIPUR</a>                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" href="/admin/dashboard">Admin Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="/admin/add_domain">Add Domain</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="modal" data-bs-target="#evaluatorModal">Add Evaluator</a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link active" href="#contact">Contact Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                          <li class="text-light"><span>Hello, {{ Auth::guard('admin')->user()->name }}</span></li>
                            <li><form method="POST" action = "/admin/logout">@csrf<button class="dropdown-item">Logout</button> </form></li>
                        </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
        </header>
    </div>

    <section id="searchbox">
        <!-- Search Box -->
        <div class="search-box">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-9">
                <div class="d-flex justify-content-center">
                    <form action="{{ route('admin.search') }}" method="GET" class="col-8">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by project name">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-info"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

    <div class = >
        
    </div>
    

    <section class="tablecol">
        <div class="container bg-light w-75 text-dark" id="form-admin">
            @if (session('success'))
            <div class="d-flex justify-content-center">
                <div class="alert alert-success  text-center w-50">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            
            @if($errors->has('email'))
            <div class="alert alert-danger text-center">
                {{ $errors->first('email') }}
            </div>
            @endif

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="nav nav-pills nav-fill mx-auto">
                            <li class="nav-item">
                              <a onclick="showTab('table1Container')" class="nav-link active" data-bs-toggle="pill" href="#table1Container">Unassigned <span class="test badge badge-dark">{{ $unassignedProjects->count()}}</span></a>
                            </li>
                            <li class="nav-item">
                              <a onclick="showTab('table2Container')" class="nav-link" data-bs-toggle="pill" href="#table2Container">Awaiting Consent <span class="test badge badge-dark">{{ $awaitingConsentProjects->count()}}</span></a>
                            </li>
                            <li class="nav-item">
                              <a onclick="showTab('table3Container')" class="nav-link" data-bs-toggle="pill" href="#table3Container">Assigned <span class="test badge badge-dark">{{ $assignedProjects->count()}}</span></a>
                            </li>
                            <li class="nav-item">
                              <a onclick="showTab('table4Container')" class="nav-link" data-bs-toggle="pill" href="#table4Container">Evaluation Complete <span class="test badge badge-dark">{{ $evaluationCompleteProjects->count()}}</span></a>
                            </li>
                            <li class="nav-item">
                              <a onclick="showTab('table5Container')" class="nav-link" data-bs-toggle="pill" href="#table5Container">Completed <span class="test badge badge-dark">{{ $completedProjects->count()}}</span></a>
                            </li>
                        </ul>
                      </div>
                </div>
            </nav>
           
            <!-- Table-1 -->
            <div id="table1Container" class="column active ">
                <h3 class="my-4">Unassigned Projects</h3>
                @if ($unassignedProjects->isEmpty())
                    <h5 class="text-center">No unassigned projects.</h5>
                @else
                <table class="table table-hover border border-black">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Title</th>
                            <th>Domain</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unassignedProjects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->title }}</td>
                                <td>{{ $project->domain->name}}</td>
                                <td>
                                    <a href="{{ route('admin.assignEvaluator', ['projectId' => $project->id]) }}"><button class="btn btn-outline-dark">Assign Evaluator</button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            
            <!-- Table 2 -->
            <div id="table2Container" class="column">
                  
                <h3 class="my-4">Awaiting Consent</h3>
                @if ($awaitingConsentProjects->isEmpty())
                    <h5 class="text-center">No Awaiting projects.</h5>
                @else
                <table class="table table-hover border border-black">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Title</th>
                            <th>Domain</th>
                            <th>Evaluator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($awaitingConsentProjects as $assignment)
                            <tr>
                                <td>{{ $assignment->project->id }}</td>
                                <td>{{ $assignment->project->title }}</td>
                                <td>{{ $assignment->project->domain->name }}</td>
                                <td>{{ $assignment->evaluator->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        
            <!-- Table 3 -->
            <div id="table3Container" class="column">
                  
                <h3 class="my-4">Assigned Projects</h3>
                @if ($assignedProjects->isEmpty())
                    <h5 class="text-center">No Assigned projects.</h5>
                @else
                <table class="table table-hover border border-black">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Title</th>
                            <th>Domain</th>
                            <th>Evaluator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignedProjects as $assignment)
                            <tr>
                                <td>{{ $assignment->project->id }}</td>
                                <td>{{ $assignment->project->title }}</td>
                                <td>{{ $assignment->project->domain->name }}</td>
                                <td>{{ $assignment->evaluator->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- Table 4 -->
            <div id="table4Container" class="column">
                  
                <h3 class="my-4">Evaluation Complete</h3>
                @if ($evaluationCompleteProjects->isEmpty())
                    <h5 class="text-center">No projects whose evaluation is complete.</h5>
                @else
                <table class="table table-hover border border-black">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Title</th>
                            <th>Domain</th>
                            <th>Evaluator</th>
                            <th>Evaluator Comments</th>
                            <th>Evaluator Remarks</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluationCompleteProjects as $assignment)
                            <tr>
                                <td>{{ $assignment->project->id }}</td>
                                <td>{{ $assignment->project->title }}</td>
                                <td>{{ $assignment->project->domain->name }}</td>
                                <td>{{ $assignment->evaluator->name }}</td>
                                <td>{{ $assignment->evaluator_comments }}</td>
                                <td>{{ $assignment->evaluator_remarks }}</td>
                                <td>
                                    <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#commentsModal{{ $assignment->id }}">Give Comments</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- Table 5 -->
            <div id="table5Container" class="column">
                  
                <h3 class="my-4">Completed Projects</h3>
                @if ($completedProjects->isEmpty())
                    <h5 class="text-center">No Completed projects.</h5>
                @else
                <table class="table table-hover border border-black">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Title</th>
                            <th>Domain</th>
                            <th>Evaluator</th>
                            <th>Evaluator Comments</th>
                            <th>Evaluator Remarks</th>
                            <th>Admin Comments</th>
                            <th>Admin Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($completedProjects as $assignment)
                            <tr>
                                <td>{{ $assignment->project->id }}</td>
                                <td>{{ $assignment->project->title }}</td>
                                <td>{{ $assignment->project->domain->name }}</td>
                                <td>{{ $assignment->evaluator->name }}</td>
                                <td>{{ $assignment->evaluator_comments }}</td>
                                <td>{{ $assignment->evaluator_remarks }}</td>
                                <td>{{ $assignment->admin_comments }}</td>
                                <td>{{ $assignment->admin_remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
    </section>
  

    @foreach ($evaluationCompleteProjects as $assignment)
    <div class="modal fade" id="commentsModal{{ $assignment->id }}" tabindex="-1" aria-labelledby="commentsModalLabel{{ $assignment->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModalLabel{{ $assignment->id }}">Give Comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.submitAdminComments',  ['id' => $assignment->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="col-form-label" for="comments">Comments</label>
                            <textarea class="form-control" name="admin_comments" id="comments" cols="30" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="remarks">Remarks</label>
                            <select class="form-control" name="admin_remarks" id="remarks" required>
                                <option value="">Select your remark</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Modify">Modify</option>
                            </select>
                        </div>
                        <button class="btn btn-dark" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="modal fade" id="evaluatorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add an Evaluator</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="/evalregister" >
                 @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Evaluator's Name</label>
                        <input type="Name" class="form-control" name="name" id="firstName" placeholder="Enter evaluator's Name" required>
                        <span class="text-danger">
                            @error('name')
                               {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="inputAddress2" placeholder="Enter a valid Email" required>
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" name="password" value="123" class="form-control" id="password" required>
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" name="confirmPassword" value="123" class="form-control" id="confirmPassword" required>
                    </div>
                    <div class="col-md-12">
                        <input class="form-control" type="hidden" value="evaluator" name="role" id="" readonly>
                    </div> 
                    <div id="reviewer-input" class="col-md-12">
                      <label for="domain" class="form-label">Enter Your Domain</label>
                      <select class="form-control" name="domain_id" id="domain">
                        <option value="">Select your Domain</option>
                        @foreach ($domain as $entry)
                            <option value="{{ $entry->id}}">{{ $entry->name }}</option>
                        @endforeach
                      </select>
                 </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-dark">Register</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>


    <footer class="footer-distributed" id="contact">

        <div class="footer-left">
        <i class="bi bi-geo-alt-fill"></i><br>
        <p>Raipur Chattisgarh, India</p>
        </div>

        <div class="footer-center">
            <div>
                <i class="bi bi-phone"></i><br>
                <p>+91 1234567890</p>
            </div>
        </div>
        <div class="footer-right">
                <i class="bi bi-envelope"></i><br>
                <p>someone@yahoomail.com</p>
            </p>
        </div>
    </footer>
    <script>
    function showTab(tabName) {
      var i, columns, navLinks;
      
      columns = document.getElementsByClassName("column");
      for (i = 0; i < columns.length; i++) {
        columns[i].style.display = "none";
      }
      
      navLinks = document.getElementsByClassName("navbar")[0].getElementsByTagName("a");
      for (i = 0; i < navLinks.length; i++) {
        navLinks[i].className = navLinks[i].className.replace(" active", "");
      }
      
      document.getElementById(tabName).style.display = "block";
      event.currentTarget.className += " active";
    }

    // Show Table 1 by default
    showTab('table1Container');
    </script>
</body>
</html>


   
    


