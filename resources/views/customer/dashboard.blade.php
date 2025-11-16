@auth
        <span>Hello, {{ Auth::user()->role_name }}</span>


 
        <form action="{{ route('logout') }}" method="POST" >
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
    @endauth