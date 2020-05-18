{%extends '../templates/main.volt'%}
{%block title%} Create Forum {%endblock%}

{%block nav_locations%}
<li class="nav-item active">
    <a class="nav-link" href="/">Home <span class="sr-only"></span></a>
</li>
{%endblock%}

{%block content%}
<h2>Buat Forum</h2><br>
<div style="width: 50vw">
    <form action="/forum/create" method="post">
        <div class="form-group">
            <label for="forum_name">Nama Forum</label>
            <input name="forum_name" type="text" class="form-control" id="forum_name" placeholder="Nama forum">
        </div>
        <button type="submit" class="btn btn-primary">Buat</button>
    </form>
</div>
{%endblock%}