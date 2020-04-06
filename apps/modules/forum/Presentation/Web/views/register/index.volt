{% if success is not empty %}
    {% if success is true %}
    Register success
    {% elseif success is false %}
    Register failed
    {% endif %}
{% else %}
Register:
<form action="/forum/register" method="post">
    Username: <input type="text" name="username" /><br>
    Password: <input type="password" name="password" /><br>
    <input type="submit" value="Register" />
</form>
{% endif %}