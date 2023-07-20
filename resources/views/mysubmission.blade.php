<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Evaluator</title>
    
    <link rel="stylesheet" href="{{url('frontend/css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg bg-light border-bottom border-bottom-dark" data-bs-theme="light" >
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><img src="{{url('frontend/images/logo.gif')}}" alt="" height="50px" width="50px"> NIT RAIPUR</a>            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/student/dashboard">Student Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#rules">Guidelines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#contact">Contact Us</a>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li class="text-light"><span>Hello, {{ Auth::guard('student')->user()->name }}</span></li>
                        <li><form method="POST" action = "{{route('student.logout')}}">@csrf<button class="dropdown-item">Logout</button> </form></li>
                    </ul>
                </li>
                </ul>
            </div>
            </div>
        </nav>
    </header>
    <section class="tablecol">
        <div class="container bg-light w-75 text-dark" id="form">
            <div class="d-flex justify-content-end">
                <h4><a href="/student/dashboard" style="text-decorations:none; color:inherit;"><i class="bi bi-x-circle-fill"></i></a></h4>
            </div>
            <div class="d-flex justify-content-center">
                <h1 class="mb-2">My Submissions</h1>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="nav nav-pills nav-fill mx-auto">
                            <li class="nav-item">
                              <a onclick="showTab('table1Container')" class="nav-link active" data-bs-toggle="pill" href="#table1Container">Not Evaluated Projects</a>
                            </li>
                            <li class="nav-item">
                              <a onclick="showTab('table2Container')" class="nav-link" data-bs-toggle="pill" href="#table2Container">Evaluated Projects</a>
                            </li>
                            <li class="nav-item">
                                <a onclick="showTab('table3Container')" class="nav-link" data-bs-toggle="pill" href="#table2Container">Need Modification</a>
                            </li>
                        </ul>
                      </div>
                </div>
            </nav>

            <div class="d-flex justify-content-center">
                <div id="table1Container" class="column active w-75">
                    <h3>Not Evaluated Projects</h3>
                    @if($notEvaluatedProjects->isEmpty())
                     <h5 class="text-center"> No Projects Found</h5>
                     @else
                    <table class="table table-hover border border-black">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notEvaluatedProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>Not Evaluated</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                
                <div id="table2Container" class="column active w-75">
                    <h3>Evaluated Projects</h3>
                    @if($evaluatedProjects->isEmpty())
                     <h5 class="text-center"> No Projects Found</h5>
                     @else
                    <table class="table table-hover border border-black">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Admin Comments</th>
                                <th>Admin Remarks</th>
                                <th>Evaluator Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evaluatedProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>Evaluated</td>
                                    <td>{{ $project->assignment->admin_comments }}</td>
                                    <td>{{ $project->assignment->admin_remarks }}</td>
                                    <td>{{ $project->assignment->evaluator_remarks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

                <div id="table3Container" class="column active w-75">
                    <h3>Update required Projects</h3>
                    @if($modifiedProjects->isEmpty())
                     <h5 class="text-center"> No Projects Found</h5>
                     @else
                    <table class="table table-hover border border-black">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Admin Comments</th>
                                <th>Admin Remarks</th>
                                <th>Evaluator Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modifiedProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>Modify</td>
                                    <td>{{ $project->assignment->admin_comments }}</td>
                                    <td>{{ $project->assignment->admin_remarks }}</td>
                                    <td>{{ $project->assignment->evaluator_remarks }}</td>
                                    <td>
                                        <form action="{{ route('student.resubmit', ['id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <input type="file" name="report" class="form-control" accept=".pdf" required>
                                                <button type="submit" class="btn btn-primary">Resubmit</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

            </div>
        </div>
    </section>

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
</body>
</html>