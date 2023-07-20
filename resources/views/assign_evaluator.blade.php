<!-- assign_evaluator.blade.php -->
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

    <section class="tablecol">
        <div class="container bg-light w-75 text-dark" id="form">
            <div class="d-flex justify-content-end">
                <h4><a href="/admin/dashboard" style="text-decorations:none; color:inherit;"><i class="bi bi-x-circle-fill"></i></a></h4>
            </div>
            <div class="d-flex justify-content-center">
                <h1 class="mb-2">Assign Evaluator</h1>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="nav nav-pills nav-fill mx-auto">
                            <li class="nav-item">
                              <a onclick="showTab('table1Container')" class="nav-link active" data-bs-toggle="pill" href="#table1Container">Project Details </a>
                            </li>
                            <li class="nav-item">
                              <a onclick="showTab('table2Container')" class="nav-link" data-bs-toggle="pill" href="#table2Container">Declined History</a>
                            </li>
                        </ul>
                      </div>
                </div>
            </nav>
            
            <div class="d-flex justify-content-center">
                <div id="table1Container" class="column active w-75">
                    <h3>Project Details</h3>
                    <table class="table border border-black mb-5">
                        <tbody>
                            <tr>
                                <td><strong>Project ID:</strong></td>
                                <td>{{ $project->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Title:</strong></td>
                                <td>{{ $project->title }}</td>
                                 
                            </tr>
                            <tr>
                                <td><strong>Abstract:</strong></td>
                                <td>{{ $project->abstract }}</td>
                            </tr>
                            <tr>
                                <td><strong>Domain:</strong></td>
                                <td>{{ $project->domain->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h3>Select Evaluator</h3>
                    <div class="row justify-content-center py-4">
                    <form action="{{ route('admin.assignEvaluatorSearch',['projectId' => $project->id]) }}" method="GET" class="col-8">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by evaluator name">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-info"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="form-group">
                        <table class="table table-striped border border-black">
                            <thead>
                                <tr>
                                    <td><strong>Evaluator Name</strong></td>
                                    <td><strong>Evaluator email</strong></td>
                                    <td><strong>Action</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluators as $evaluator)
                                <tr>
                                    <td>{{ $evaluator->name }}</td>
                                    <td>{{ $evaluator->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.submitEvaluatorAssignment', $project->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="evaluator_id" value="{{ $evaluator->id }}">
                                            <button class='btn btn-primary btn-sm' type="submit">Assign</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                
                <div id="table2Container" class="column active">
                    <div class="tab-pane" id="declined" role="tabpanel" aria-labelledby="declined-tab">
                        <h3>Evaluators Declined History</h3>
                        <table class="table table-striped border border-black">
                            <thead>
                                <tr>
                                    <th>Evaluator Name</th>
                                    <th>Declined Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($declinedEvaluators as $evaluator)
                                    <tr>
                                        <td>{{ $evaluator->name }}</td>
                                        <td>{{ $evaluator->declined_at }}</td>
                                    </tr>
    
                                @endforeach
                            </tbody>
                        </table>
    
                    </div>
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
</html>