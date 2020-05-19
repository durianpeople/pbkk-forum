
{% extends '../template/main.volt' %}
{% block head %}{% endblock %}
{% block title %}Home{% endblock %}
{% block custom_style %}
.table-stats {
  border: 1px solid black;
  font-size: .85rem;
  text-align: center;
  padding: 20pt;
}
.page-wrapper {
  color: black;
  padding: 25pt;
}
.post-content {
  padding: 20pt;
  margin: 10pt;
  border-radius:25px;
  color: white;
}
.table-title {
  margin-bottom: 20pt;
}
.posts-buttons {
  color: white;
}
.comments {
  margin: 50px;
}
.vote-btn {
  border-radius:10px;
}

.dropdown {
  color: black;
}
.dropdown-menu {
  padding: 10px;
  left: -50px;
  min-width:7rem;
}
.delete-btn {
  border-radius:5px;
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
        <li><a href="/profile">Edit Profile <span class="fa fa-edit"></span></a></li>
        <li><a href="/logout">Sign Out <span class="fa fa-sign-out"></span></a></li>
      </ul>
      </li>
    </ul>
  </div>
{% endblock %}
{% block content %}
<div class="container">
  <div class="page-wrapper bg-white">
  {{ flashSession.output() }}
    <h2>Edit Profile</h2>
    <form action="/profile" method="POST">
      <div class="form-group has-error">
        <label>Username</label>
        <input type="text" class="form-control" name="profile_username" value="{{ user_info.username }}" placeholder="Type Your New Username" required>
      </div>
      <div class="form-group has-error">
        <label>Old Password</label>
        <input name="profile_old_password" class="form-control" rows="6" placeholder="Type Your Old Password Here" required></input>
      </div>
      <div class="form-group has-error">
        <label>New Password</label>
        <input name="profile_new_password" class="form-control" rows="6" placeholder="Type Your New Password Here"></input>
      </div>
      <div class="form-group has-error">
        <label>Confirm Password</label>
        <input name="profile_confirm_password" class="form-control" rows="6" placeholder="Re-Type Your New Password Here"></input>
      </div>
      <div class="form-group has-error">
        <button type="submit" class="btn btn-info btn-lg btn-block"><span class="fa fa-paper-plane"> Submit</span></button>
      </div>
    </form>
  </div>

</div>
{% endblock %}
