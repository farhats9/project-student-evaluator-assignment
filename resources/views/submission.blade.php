<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
	<title>Student Login</title>
	<meta name="description" content="">  
	<meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!--CSS & Bootstrap-->
  <link rel="stylesheet" href="{{url('frontend/css/style.css')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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
                      <a class="nav-link active" href="/student/dashboard">Student Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="#rules">Guidelines</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="/student/mysubmission">My Submissions</a>
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
    </div>

    <section class="container bg-light w-50 text-dark" id="form">
      @if (session('success'))
      <div class="alert alert-success text-center">
          {{ session('success') }}
      </div>
    @endif
    
        <form class="row g-3" action="/student/save" method="post" enctype="multipart/form-data">
          @csrf
            <h1>Submission Form</h1>
            <div class="col-md-12">
                <label for="title" class="form-label">Title</label>
                <input type="title" class="form-control" id="title" name="title" placeholder="Title of your Paper" required>
            </div>
            <div class="col-12">
                <label for="abstract" class="form-label">Abstract</label>
                <textarea class="form-control" name="abstract" id="abstract" cols="30" rows="5" placeholder="Do not exceed 100 words" required></textarea>
            </div>
            <div class="col-12">
                <label for="keywords" class="form-label">Keywords</label>
                <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Atleast 5 words" required>
            </div>
          <div class="col-md-12">
            <label for="domain" class="form-label">Domain</label>
            <select class="form-control" name="domain_id" id="domain">
              <option value="">Select your Domain</option>
              @foreach ($domain as $entry)
                  <option value="{{ $entry->id }}">{{ $entry->name }}</option>
              @endforeach
            </select>
        </div>
            <div class="col-md-12">
                <label for="docType" class="form-label">Document Type</label>
                <select id="document-type" name="docType" class="form-select" required>
                    <option value="">Select Document Type</option>
                    <option value="M.Tech Report">M.Tech Report</option>
                    <option value="PhD Thesis">PhD Thesis</option>
                    <option value="Research Paper">Research Paper</option>
                </select>
            </div>
            <div class="col-md-12">
                <label for="report">Upload File</label>
                <input type="file" id="file" name="report" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-outline-dark">Submit</button>
            </div>
        </form>
    </section>
    <div id="rules"></div>
    <section id="about">
        <div class="col-twelve about">
            <div class="container bg-light w-75 text-dark">
                <h1>Guidelines</h1>
    
                <div class="intro-info">
                    <ol class="list-group list-group-numbered lead">
                      <li class="list-group-item-dark">1. Follow the prescribed format and structure guidelines provided by the educational institution or department. This includes the title page, abstract, table of contents, chapters, references, etc.</li>
                      <li class="list-group-item-dark">2. Maintain a high standard of language and grammar throughout the thesis. Proofread and edit the document thoroughly to correct any spelling, punctuation, or grammatical errors.</li>
                      <li class="list-group-item-dark">3. Avoid plagiarism by properly citing and referencing all sources used in the thesis. Follow the recommended citation style, such as APA, MLA, or Chicago, as specified by the institution.</li>
                      <li class="list-group-item-dark">4. Ensure that the thesis demonstrates originality and contributes to the existing body of knowledge in the field. Clearly state the research problem, objectives, methodology, and findings to showcase the novelty of the work.</li>
                      <li class="list-group-item-dark">5. Present ideas and arguments in a clear and coherent manner. Use logical transitions between sections and paragraphs to enhance the flow of the thesis.</li>
                      <li class="list-group-item-dark">6. Include relevant and well-labeled figures, tables, charts, and graphs to support the findings and improve the visual presentation of data.</li>
                      <li class="list-group-item-dark">7. Provide a comprehensive list of references cited in the thesis. Follow the recommended citation format consistently and accurately.</li>
                      <li class="list-group-item-dark">8.  Adhere to the submission deadlines set by the institution. Allow sufficient time for revisions, proofreading, and formatting before the final submission.</li>
                    </ol>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</head>

</html>