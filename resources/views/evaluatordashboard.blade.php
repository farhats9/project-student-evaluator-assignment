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
                      <a class="nav-link active" href="/evaluator/dashboard">Evaluator Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="#rules">Guidelines</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="#contact">Contact Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                            Account
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                          <li class="text-light"><span>Hello, {{ Auth::guard('evaluator')->user()->name }}</span></li>
                          <li><form method="POST" action = "/evaluator/logout">@csrf<button class="dropdown-item">Logout</button> </form></li>
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
                    <form action="{{ route('evaluator.search') }}" method="GET" class="col-8">
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

    <section class="tablecol">
      <div class="container bg-light w-75 text-dark" id="form-admin">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav nav-pills nav-fill mx-auto">
                        <li class="nav-item">
                          <a onclick="showTab('table1Container')" class="nav-link active" data-bs-toggle="pill" href="#table1Container">Awaiting Consent <span class="test badge badge-dark">{{ $unassignedProjects->count()}}</span></a>
                        </li>
                        <li class="nav-item">
                          <a onclick="showTab('table2Container')" class="nav-link" data-bs-toggle="pill" href="#table2Container">Ongoing <span class="test badge badge-dark">{{ $assignedProjects->count()}}</span></a>
                        </li>
                        <li class="nav-item">
                          <a onclick="showTab('table3Container')" class="nav-link" data-bs-toggle="pill" href="#table3Container">Completed <span class="test badge badge-dark">{{ $completedProjects->count()}}</span></a>
                        </li>
                        <li class="nav-item">
                          <a onclick="showTab('table4Container')" class="nav-link" data-bs-toggle="pill" href="#table4Container">Declined <span class="test badge badge-dark">{{ $declinedProjects->count()}}</span></a>
                        </li>
                    </ul>
                  </div>
              </div>
          </nav>
          <section>
            @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
          @endif
              <!-- Table-1 -->
          <div id="table1Container" class="column active">
            <h2>Awaiting Consent</h2>
                @if ($unassignedProjects->isEmpty())
                    <h5 class="text-center">No projects waiting for consent.</h5>
                @else
        <table class='table'>
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Title</th>
                    <th>Abstract</th>
                    <th>Domain</th>
                    <th>Accept</th>
                    <th>Decline</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unassignedProjects as $assignment)
                    <tr>
                        <td>{{ $assignment->project->id }}</td>
                        <td>{{ $assignment->project->title }}</td>
                        <td>{{ $assignment->project->abstract }}</td>
                        <td>{{ $assignment->project->domain->name }}</td>
                        <td>
                            <form action="{{ route('evaluator.giveConsent', ['id' => $assignment->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="consent" value="accept">
                                <button class='btn btn-primary btn-sm' type="submit">Accept</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('evaluator.giveConsent', ['id' => $assignment->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="consent" value="decline">
                                <button class='btn btn-primary btn-sm' type="submit">Decline</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        </div>
    
        <!-- Table 2 -->
        <div id="table2Container" class="column">
            <h2>Assigned Projects</h2>
            @if ($assignedProjects->isEmpty())
                <h5 class="text-center">No assigned projects.</h5>
            @else
        <table class='table'>
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Title</th>
                    <th>Abstract</th>
                    <th>Domain</th>
                    <th>View PDF</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignedProjects as $assignment)
                    <tr>
                        <td>{{ $assignment->project->id }}</td>
                        <td>{{ $assignment->project->title }}</td>
                        <td>{{ $assignment->project->abstract }}</td>
                        <td>{{ $assignment->project->domain->name }}</td>
                        <td>
                            <a href="{{ route('evaluator.viewFile', ['projectId' => $assignment->project->id]) }}" target="_blank">View PDF</a>
                        </td>
                        <td>
                            <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#commentsModal{{ $assignment->id }}">Give Comments</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        </div>


        <div id="table3Container" class="column">
            <h2>Completed Projects</h2>
            @if ($completedProjects->isEmpty())
                <h5 class="text-center">No completed projects.</h5>
            @else
            <table class='table'>
                <thead>
                    <tr>
                        <th>Project ID</th>
                        <th>Title</th>
                        <th>Abstract</th>
                        <th>Domain</th>
                        <th>completed</th>
                        <th>comments</th>
                        <th>remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($completedProjects as $assignment)
                        <tr>
                            <td>{{ $assignment->project->id }}</td>
                            <td>{{ $assignment->project->title }}</td>
                            <td>{{ $assignment->project->abstract }}</td>
                            <td>{{ $assignment->project->domain->name }}</td>
                            <td>Completed</td>
                            <td>{{ $assignment->evaluator_comments }}</td>
                            <td>{{ $assignment->evaluator_remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
      </div>

      <div id="table4Container" class="column">
        
        <h3>Declined</h3>
        @if ($declinedProjects->isEmpty())
            <h5 class="text-center">No declined projects.</h5>
        @else
        <table class='table'>
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Title</th>
                    <th>Abstract</th>
                    <th>Domain</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($declinedProjects as $declinedProject)
                    <tr>
                        <td>{{ $declinedProject->project->id }}</td>
                        <td>{{ $declinedProject->project->title }}</td>
                        <td>{{ $declinedProject->project->abstract }}</td>
                        <td>{{ $declinedProject->project->domain->name }}</td>
                        <td>Declined</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
        

  @foreach ($assignedProjects as $assignment)
      <div class="modal fade" id="commentsModal{{ $assignment->id }}" tabindex="-1" aria-labelledby="commentsModalLabel{{ $assignment->id }}" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="commentsModalLabel{{ $assignment->id }}">Give Comments</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form action="{{ route('evaluator.submitComments',  ['id' => $assignment->id]) }}" method="POST">
                          @csrf
                          <div class="mb-3">
                              <label class="col-form-label" for="comments">Comments</label>
                              <textarea class="form-control" name="evaluator_comments" id="comments" cols="30" rows="5" required></textarea>
                          </div>
                          <div class="mb-3">
                              <label class="col-form-label" for="remarks">Remarks</label>
                              <select class="form-control" name="evaluator_remarks" id="remarks" required>
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
      

      

    </section>
          
  </section>












<script>
    $(document).ready(function() {
        $('#remarksModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var assignmentId = button.data('assignment-id');
            $('#assignmentId').val(assignmentId);
        });
    });
</script>

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

        showTab('table1Container');
      </script>
</body>
</html>