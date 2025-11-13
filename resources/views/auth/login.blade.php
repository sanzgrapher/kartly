 <form method="POST" action="{{ route('login') }}">
     @csrf

     <h1>Login</h1>

     <div>
         <label for="email">Email</label>
         <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

     </div>

     <div>
         <label for="password">Password</label>
         <input id="password" type="password" name="password" required>

     </div>

     <div>
         <label>
             <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
             Remember me
         </label>
     </div>
     @error('email')
     <div style="color:red;" >{{$message}}</div>
         
     @enderror

     <div>
         <button type="submit" class="btn">Login</button>
     </div>

     <div>


         @if (Route::has('register'))
             <a href="{{ route('register') }}">Register</a>
         @endif

         
     </div>
 </form>
