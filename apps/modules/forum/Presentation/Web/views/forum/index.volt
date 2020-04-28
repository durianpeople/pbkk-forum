{%extends '../templates/main.volt'%}
{%block title%} Forum {%endblock%}

{%block nav_locations%}
<li class="nav-item active">
    <a class="nav-link" href="/">Home <span class="sr-only"></span></a>
</li>
{%endblock%}

{%block content%}
<a href="/forum/create"><button type="button" class="btn btn-dark">Buat Forum</button></a><br><br>
Joined forums:<br>
{% if joined_forums is empty %}
Anda belum bergabung ke forum apapun.<br>
{%endif%}
<ul>
    {% for forum in joined_forums %}
    <li><a href="/forum/view?id={{forum.forum_id}}">{{forum.forum_name}}</a></li>
    {% endfor %}
</ul>
All forums:<br>
{% if all_forums is empty %}
Tidak ada forum.<br>
{%endif%}
<ul>
    {% for forum in all_forums %}
    <li><a href="/forum/view?id={{forum.forum_id}}">{{forum.forum_name}}</a></li>
    {% endfor %}
</ul>
{%endblock%}