{% extends '../template/main.volt' %}
{% block head %}{% endblock %}
{% block title %}Home{% endblock %}
{% block custom_style %}
.cover {
text-align: center !important;
display: block;
background-color: rgba(0,0,0,0.5);
margin: auto;
padding: 40px;
border-radius: 5px;
}
.dropdown {
color: black;
}
.dropdown-menu {
padding: 10px;
left: -30px;
min-width:7rem;
}

{% endblock %}
{% block navbar_content %}
{% endblock %}
{% block content %}
<div class="inner cover">
    <h1> It Seems you get lost and browse 404 page.</h1>
    <br>
    <h3> Let's go home!</h3>
    <p class="lead">
        <a href="/" class="btn btn-outline-light">Back to Home</a>
    </p>
</div>
{% endblock %}