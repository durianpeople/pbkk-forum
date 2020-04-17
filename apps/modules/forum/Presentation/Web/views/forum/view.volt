Forum: <b>{{forum.forum_name}}</b>
{%if not forum.joined%}
<a href="/forum/join?id={{forum.forum_id}}">Join</a>
{%else%}
<a href="/forum/leave?id={{forum.forum_id}}">Leave</a>
{%endif%}
<br>
<br>
Admin: <b>{{forum.admin.username}}</b> ({{forum.admin.id}})<br>
Member:
<ul>
    {%for member in forum.members%}
    <li>
        <b>{{member.username}}</b> ({{member.id}}) 
        {%if forum.is_admin and member.id is not forum.admin.id%}
        <a href="/forum/ban?id={{forum.forum_id}}&userid={{member.id}}">Ban</a>
        {%endif%}
    </li>
    {%endfor%}
</ul>
{%if forum.is_admin%}
You are the admin of this forum
{%endif%}