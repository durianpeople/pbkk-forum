{%extends '../templates/main.volt'%}
{%block title%} Index {%endblock%}

{%block nav_buttons%}
{% if loggedin %}
<li class="nav-item active">
    <a class="nav-link" href="/edit">Edit profile <span class="sr-only"></span></a>
</li>
<li class="nav-item active">
    <a class="nav-link" href="/logout">Logout <span class="sr-only"></span></a>
</li>
{%else%}
<li class="nav-item active">
    <a class="nav-link" href="/login">Login <span class="sr-only"></span></a>
</li>
<li class="nav-item active">
    <a class="nav-link" href="/register">Register <span class="sr-only"></span></a>
</li>
{%endif%}
{%endblock%}

{%block nav_locations%}
{% if loggedin %}
<li class="nav-item active">
    <a class="nav-link" href="/forum">All Forums <span class="sr-only"></span></a>
</li>
{% endif %}
{%endblock%}

{%block content%}
{% if loggedin %}
Halo, <b>{{ user_info.username }}</b>.<br>
Jumlah award: {{user_info.awards_count}}<br>
{% else %}
Anda belum log in
{% endif %}
{%endblock%}