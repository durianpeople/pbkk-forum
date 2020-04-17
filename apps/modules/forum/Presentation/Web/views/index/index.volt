{% if loggedin %}
Anda logged in sebagai {{ user_info.username }}. <a href="/edit">Edit profile</a> <a href="/logout">Logout</a><br>
Jumlah award: {{user_info.awards_count}}<br>
<a href="/forum">See forums</a>
{% else %}
Anda belum log in<br>
<a href="/login">Login</a><br>
<a href="/register">Register</a>
{% endif %}