<a href="/">Home</a><br>
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
<a href="/forum/create">Buat forum</a>