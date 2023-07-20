<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
	<title>Login Page</title>
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

</head>
<body>
    <div class="container-fluid">
        <header>
            <nav class="navbar fixed-top navbar-expand-lg bg-light border-bottom border-bottom-dark" data-bs-theme="light" >
              <div class="container-fluid">
                <a class="navbar-brand" href="/"><img src="{{url('frontend/images/logo.gif')}}" alt="" height="50px" width="50px"> NIT RAIPUR</a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="#contact">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Signup
                        </button>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
        </header>
    </div>
    <section class="container bg-light w-50 text-dark" id="form">
      @if($errors->has('loginfailed'))
          <div class="alert alert-danger text-center">
              {{ $errors->first('loginfailed') }}
          </div>
      @endif
      @if($errors->has('email'))
          <div class="alert alert-danger text-center">
              {{ $errors->first('email') }}
          </div>
      @endif
      @if($errors->has('confirmPassword'))
          <div class="alert alert-danger text-center">
              {{ $errors->first('confirmPassword') }}
          </div>
      @endif
      @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
      @endif
      @if(session('message'))
            <div class="alert alert-info text-center">
                {{ session('message') }}
            </div>
      @endif
        <form class="px-4 py-3" action="/login" method="POST">
          @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Email</label>
              <input type="email" class="form-control" id="username" name="name" placeholder="email@example.com" required>
              @error('name')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              @error('password')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck">
                <label class="form-check-label" for="dropdownCheck">
                  Remember me
                </label>
            </div>
            <div class="col-md-12">
              <label for="role" class="form-label">Select Role</label>
              <select id="" name="role" class="form-select" required>
                  <option value="">Select role to Login</option>
                  <option value="admin">Admin</option>
                  <option value="evaluator">Evaluator</option>
                  <option value="student">Student</option>
              </select>
          </div> 
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Forgot password?</a>
          <br/>
          <div class="col-12">
            <button type="submit" class="btn btn-outline-dark">Login</button>
        </div>
        
        </form>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registration Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="POST" action="/register" >
                     @csrf
                        <div class="col-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="Name" class="form-control" name="name" id="firstName" placeholder="Enter your Name" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="inputAddress2" placeholder="Enter a valid Email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
                        </div>
                        <div class="col-md-12">
                            <label for="role" class="form-label">Select Role</label>
                            <select id="user-type" name="role" class="form-select" required>
                                <option value="">Select role to Register</option>
                                <option value="admin">Admin</option>
                                <option value="evaluator">Evaluator</option>
                                <option value="student">Student</option>
                            </select>

                        </div> 

                        <div id="reviewer-input" class="col-md-12" style="display: none;">
                          <label for="domain" class="form-label">Enter Your Domain</label>
                          {{-- <select class="form-control" name="domain" id="domain">
                            <option value="">Select your Domain</option>
                            <option value="AI">AI</option>
                            <option value="ML">ML</option>
                            <option value="IOT">IOT</option>
                          </select> --}}
                          <select class="form-control" name="domain_id" id="domain">
                            <option value="">Select your Domain</option>
                            @foreach ($domain as $entry)
                                <option value="{{ $entry->id }}">{{ $entry->name }}</option>
                            @endforeach
                          </select>

                      </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-dark">Register</button>
                        </div>
                    </form>
                    <script>
                      // Get the select element
                      const roleSelect = document.getElementById('user-type');
                      // Get the reviewer input div
                      const reviewerInput = document.getElementById('reviewer-input');
                
                      // Add event listener to the select element
                      roleSelect.addEventListener('change', function () {
                          // Check if the selected value is "reviewer"
                          if (roleSelect.value === 'evaluator') {
                              // Show the reviewer input div
                              reviewerInput.style.display = 'block';
                          } else {
                              // Hide the reviewer input div
                              reviewerInput.style.display = 'none';
                          }
                      });
                    </script>
                </div>
            </div>
            </div>
        </div>
    </section >

    <section id="about">
        <div class="col-twelve about">
            <div class="container bg-light text-dark">
                <h1>About </h1>
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


    

</body>
</head>

</html>