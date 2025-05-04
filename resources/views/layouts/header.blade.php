<nav class="navbar navbar-light bg-light mb-4 border-bottom">
    <div class="container-fluid justify-content-end">
      <span class="me-3">Hi, {{ Auth::user()->name }}</span>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline-secondary btn-sm">Logout</button>
      </form>
    </div>
  </nav>
