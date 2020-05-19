{% extends '../template/main.volt' %}
{% block head %}{% endblock %}
{% block title %}Home{% endblock %}
{% block custom_style %}
.page-wrapper {
background-color: rgba(0, 0, 0, 0.5);
padding: 25px;
margin: 25px;
margin-left: 100px;
margin-right: 100px;
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
            <a class="nav-link" href="/forum">Forums</a>
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
</div>
{% endblock %}
{% block content %}
<div class="page-wrapper">
    <form action="/post/create" method="POST">
        <div class="form-group has-error">
            <label>Title</label>
            <input type="text" class="form-control" name="post_title" placeholder="Insert Title Here!" required>
        </div>
        <div class="form-group has-error">
            <label>Content</label>
            <textarea name="post_content" class="form-control" rows="6" placeholder="Insert Content Here!"
                required></textarea>
        </div>
        <div class="form-group has-error">
            <input type="hidden" name="forum_id" value="{{this.session.get('forum_id')}}" />
            <button type="submit" class="btn btn-success btn-lg btn-block"><span class="fa fa-paper-plane">
                    Submit</span></button>
        </div>
    </form>
</div>
{% endblock %}