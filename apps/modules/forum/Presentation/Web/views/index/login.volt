{%extends '../templates/main.volt'%}
{%block nav_locations%}
{%endblock%}
{%block nav_buttons%}
<li class="nav-item active">
    <a class="nav-link" href="/register">Register <span class="sr-only"></span></a>
</li>
{%endblock%}

{%block title%} Login {%endblock%}


{%block content%}
<h2>Login</h2><br>
<div style="width: 50vw">
    <form action="/login" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input name="username" type="text" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <br>
    {{flashSession.output()}}
</div>
{%endblock%}