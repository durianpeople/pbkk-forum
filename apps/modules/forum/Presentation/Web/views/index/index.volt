{% if loggedin %}
Anda logged in sebagai {{ user_info.username }}<br>
<a href="/forum/logout">Logout</a>
{% else %}
Anda belum log in<br>
<a href="/forum/login">Login</a><br>
<a href="/forum/register">Register</a>
{% endif %}