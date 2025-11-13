 @auth
     <span>Hello, {{ Auth::user()->name }}</span>

     <form action="{{ route('logout') }}" method="POST" style="display: inline;">
         @csrf
         <button type="submit">Logout</button>
     </form>
 @else
     <a href="{{ route('login') }}">Login</a>
 @endauth

<li>
    <ul></ul>
    <ul></ul>
    <ul></ul>
</li>
