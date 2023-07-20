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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

</head>

<body>

    <div class="container-fluid">
        <header>
            <nav class="navbar fixed-top navbar-expand-lg bg-light border-bottom border-bottom-dark" data-bs-theme="light" >
              <div class="container-fluid">
                <a class="navbar-brand" href="/admin/dashboard"><i class="bi bi-journal-richtext"></i>LOGO</a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" href="/admin/dashboard">Admin Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="/admin/add_domain">Add Domain</a>
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
                <h4><a href="/admin/dashboard" style="text-decoration: none; color: inherit;"><i
                            class="bi bi-x-circle-fill"></i></a></h4>
            </div>
            @if (session('success'))
            <div class="d-flex justify-content-center">
                <div class="alert alert-success text-center w-50">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-center">
                <h2>Domains</h2>
            </div>

            <div class="domainhead d-flex justify-content-center mb-5">
                <form method="POST" action="{{ route('admin.saveDomain') }}" class="input-group w-50">
                    @csrf
                    <input class="form-control" type="text" placeholder="Add new domain here "name="name" id="name" required>
                    <button type="submit" class="btn btn-outline-dark">Add Domain</button>
                </form>
            </div>

            <div class="container w-50 my-10">
                <div id="table1Container">
                    <h3>List of Domain</h3>
                    @if ($domain->isEmpty())
                    <p>No domains found.</p>
                    @else
                    <table class="table table-hover border border-black">
                        <thead>
                            <tr>
                                <th>Domain name</th>
                                <th> Status</th>
                                <th> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($domain as $entry)
                            <tr>
                                <td>{{ $entry->name }}</td>
                                <td>@if($entry->status==1)
                                    Active
                                    @else
                                    InActive
                                    @endif
                                </td>
                                <td>
                                    @if($entry->status==1)
                                    <form action="{{ route('admin.toggle', ['id' => $entry->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="dstatus" value="2">
                                        <button class='btn btn-primary btn-sm' type="submit">Deactivate</button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.toggle', ['id' => $entry->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="dstatus" value="1">
                                        <button class='btn btn-primary btn-sm' type="submit">Activate</button>
                                    </form>
                                    @endif
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

</body>

</html>
