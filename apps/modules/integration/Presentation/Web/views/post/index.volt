{% extends '../template/main.volt' %}
{% block head %}{% endblock %}
{% block title %}Home{% endblock %}
{% block custom_script %}
 $(document).ready( function () {
    $('#post-table').DataTable();
} );
{% endblock %}
{% block custom_style %}
.topic-col {
  min-width: 16em;
}
.created-col,
.last-post-col {
  min-width: 12em;
}
.container {
  background-color: white;
  padding: 20px;
  color: black;
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
      <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="fa fa-user-circle"></span> {{ user_info.username}} </a>
      <ul class="dropdown-menu">
        <li><a href="/logout">Sign Out <span class="fa fa-sign-out"></span></a></li>
      </ul>
      </li>
    </ul>
  </div>
{% endblock %}
{% block content %}
<div class="container my-3">
  {{ flashSession.output() }}
      </nav>
        <div class="row">
          <div class="col-12">
            <h2>{{forum_name}}</h2>
            <table id="post-table" class="table table-striped table-bordered table-responsive-lg">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="topic-col">Topic</th>
                  <th scope="col" class="created-col">Created</th>
                  <th scope="col">Votes</th>
                </tr>
              </thead>
              <tbody>
              {% for post in posts %}
                <tr>
                  <td>
                    <h3 class="h6"><a href="/post/show?id={{ post.post_id }}">{{ post.post_title }}</a></h3>
                  </td>
                  <td>
                    <div>by <a href="#">{{ post.post_author_name }}</a></div>
                    <div>{{ post.post_created_date }}</div>
                  </td>
                  <td>
                    <div>{{ post.post_votes }} votes</div>
                  </td>
                </tr>
              {% endfor %}
              </tbody>
            </table>
          </div>
        </div>
      <a href="/post/create" class="btn btn-lg btn-primary"><span class="fa fa-plus"> New Post</span></a>
    </div>
{% endblock %}
