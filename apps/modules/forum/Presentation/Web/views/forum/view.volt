{%extends '../templates/main.volt'%}
{%block title%} Create Forum {%endblock%}

{%block nav_locations%}
<li class="nav-item active">
    <a class="nav-link" href="/">Home <span class="sr-only"></span></a>
</li>
{%endblock%}

{%block content%}
{{flashSession.output()}}
<h1>Forum</h1>
<div>
    <span style="font-size: xx-large; font-weight: bold">{{forum.forum_name}}</span>
    <span style="margin-left: 20px; position: relative; bottom: 5px">
        {%if not forum.joined%}
        <a href="/forum/join?id={{forum.forum_id}}"><button type="button"
                class="btn btn-primary btn-sm">Join</button></a>
        {%else%}
        <a href="/forum_posts?id={{forum.forum_id}}"><button type="button"
                class="btn btn-primary btn-sm">View posts</button></a>
        <a href="/forum/leave?id={{forum.forum_id}}"><button type="button"
                class="btn btn-danger btn-sm">Leave</button></a>
        {%endif%}
    </span>
</div>

<small>Admin: {%if forum.is_admin%}
    <b>You</b> -
    {%endif%}<b>{{forum.admin.username}}</b> ({{forum.admin.id}})</small><br><br>
Member:
<ul>
    {%for member in forum.members%}
    <li style="vertical-align: middle;padding: 10px 0">
        <span style="padding-right: 20px;">{%if member.id is user.id%}<b>You</b> - {%endif%}<b>{{member.username}}</b>
            ({{member.id}})</span>
        {%if member.id is not user.id and forum.joined%}
        <a href="/award?id={{member.id}}"><button type="button" class="btn btn-success btn-sm">Give award</button></a>
        {%endif%}

        {%if forum.is_admin and member.id is not forum.admin.id%}
        <a href="/forum/ban?id={{forum.forum_id}}&userid={{member.id}}"><button type="button"
                class="btn btn-danger btn-sm">Ban</button></a>
        {%endif%}
    </li>
    {%endfor%}
</ul>

{%endblock%}