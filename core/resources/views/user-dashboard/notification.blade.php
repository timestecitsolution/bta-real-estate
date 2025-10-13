<form method="POST" action="{{ route('user.logout') }}">
    @csrf
    <button class="nav-link" style="color: white !important; background-color: red !important;" type="submit" class="btn btn-danger">Logout</button>
</form>