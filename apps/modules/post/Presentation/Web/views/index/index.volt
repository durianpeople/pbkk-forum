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
<div class="collapse navbar-collapse" id="navbarsExampleDefault">
    {% if loggedin %}
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="/post">Posts</a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span
                    class="fa fa-user-circle"></span> {{ user_info.username}} </a>
            <ul class="dropdown-menu">
                <li><a href="/logout">Sign Out <span class="fa fa-sign-out"></span></a></li>
            </ul>
        </li>
    </ul>
    {% endif %}
</div>
{% endblock %}
{% block content %}
<div class="inner cover">
    {% if loggedin %}
    <h1> Hello, {{ user_info.username }} </h1>
    <h2>Browse posts using navbar</h2>
    <br>
    <p>Or you can Click Here</p>
    <p class="lead">
        <a href="/post" class="btn btn-outline-light">Browse Posts</a>
    </p>
    {% else %}
    <h1 class="cover-heading">DISPLAY</h1>
    <p class="lead">
        Discuss & play
    </p>
    <p class="lead">
        <a href="/register" class="btn btn-outline-light">Sign Up here!</a>
    </p>
    <p class="lead small">
        Already Have an account?
    </p>
    <p class="lead">
        <a href="/login" class="btn btn-outline-light">Sign In here!</a>
    </p>
    {% endif %}
</div>
{% endblock %}