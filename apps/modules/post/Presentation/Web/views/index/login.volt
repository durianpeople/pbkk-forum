{% extends '../template/main.volt' %}
{% block head %}{% endblock %}
{% block title %}Login{% endblock %}
{% block custom_style %}
.login-form {
  background-color: rgba(0, 0, 0, 0.7);
  width: 350px;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  margin: 30px auto;
  text-align: center;
}
.login-form h2 {
      margin: 10px 0 25px;
  }
  .login-form form {
  background-color: rgba(255, 255, 255, 0.8);
  color: #7a7a7a;
  border-radius: 5px;
    margin-bottom: 15px;
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      padding: 30px;
  }
  .login-form .btn {        
      font-size: 16px;
      font-weight: bold;
  background: #3598dc;
  border: none;
      outline: none !important;
  }
.login-form .btn:hover, .login-form .btn:focus {
  background: #2389cd;
}
.login-form a {
  color: #fff;
  text-decoration: underline;
}
.login-form a:hover {
  text-decoration: none;
}
.login-form form a {
  color: #7a7a7a;
  text-decoration: none;
}
.login-form form a:hover {
  text-decoration: underline;
}
{% endblock %}
{% block navbar_content %}
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
  </div>
  <ul class="navbar-nav navbar-right">
    <li>
      <a class="btn btn-outline-primary" href="/register">Sign up</a>
    </li>
  </ul>
{% endblock %}
{% block content %}
<div class="login-form">
  <form action="/login" method="POST">
    <h2 class="text-center">Sign In</h2>
    {{ flashSession.output() }}
    <div class="form-group has-error">
      <input type="text" class="form-control" name="username" placeholder="Username" required="required">
    </div>
    <div class="form-group has-error">
      <input type="password" class="form-control" name="password" placeholder="Password" required="required">
    </div>
    <div class="form-group has-error">
      <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
    </div>
  </form>
  <p class="text-center small">Don't have an account? <a href="/register">Sign up here!</a></p>
</div>
{% endblock %}
