{%extends '../templates/main.volt'%}
{%block nav_locations%}
<li class="nav-item active">
    <a class="nav-link" href="/forum">All Forums <span class="sr-only"></span></a>
</li>
{%endblock%}
{%block nav_buttons%}
<li class="nav-item active">
    <a class="nav-link" href="/logout">Logout <span class="sr-only"></span></a>
</li>
{%endblock%}

{%block title%} Edit Profile {%endblock%}


{%block content%}
<h2>Edit Profile</h2><br>
<div style="width: 50vw">
    <form action="/edit" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input name="username" type="text" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Old password</label>
            <input name="old_password" type="password" class="form-control" id="exampleInputPassword1"
                placeholder="Old password">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">New password</label>
            <input name="new_password" type="password" class="form-control" id="exampleInputPassword1"
                placeholder="New password">
        </div>
        <button type="submit" class="btn btn-primary">Change</button>
    </form>
    <br>
    {{flashSession.output()}}
</div>
{%endblock%}