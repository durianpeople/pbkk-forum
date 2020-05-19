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
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/forum">Forum</a>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="fa fa-user-circle"></span> {{ user_info.username}} </a>
      <ul class="dropdown-menu">
        <li><a href="/logout">Sign Out <span class="fa fa-sign-out"></span></a></li>
      </ul>
      </li>
    </ul>
  </div>
{% endblock %}
{% block content %}
<div class="inner cover">
  <h1> Hello, {{ user_info.username }} </h1>
  <h2>Browse posts using navbar</h2>
  <br>
  <p>Or you can Click Here</p>
  <p class="lead">
    <a href="/forum" class="btn btn-outline-light">Browse Forums</a>
  </p>
</div>
{% endblock %}
