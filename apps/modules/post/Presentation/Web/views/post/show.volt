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
left: -30px;
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
</div>
{% endblock %}
{% block content %}
<div class="container">
    {{ flashSession.output() }}
    <div class="page-wrapper bg-white">
        <div class="discussion">
            <!--Card-->
            <div class="card mb-4">

                <!--Card content-->
                <div class="card-body">

                    <p style="margin-bottom:2rem;">
                        <span>by <a href="">{{ post_info.post_author_name }}</a> on
                            {{ post_info.post_created_date }}</span>
                        {% if user_info.id == post_info.post_author_id %}
                        <span class="pull-right">
                            <a class="btn btn-danger btn-xs delete-btn" href="/post/delete?id={{ post_info.post_id }}">
                                <span class="fa fa-trash"> Delete This Post</span>
                            </a>
                        </span>
                        {% endif %}
                    </p>
                    <hr>

                    <p class="h5 my-4">{{ post_info.post_title }} </p>

                    <p>{{ post_info.post_content }}</p>
                    <div class="posts-buttons text-right">
                        <a class="vote-btn btn btn-success btn-xs"
                            href="/post/vote?id={{ post_info.post_id }}&type=post">
                            <span class="fa fa-thumbs-up"> {{post_info.post_votes}}</span>
                        </a>
                    </div>
                </div>

            </div>
            <!--/.Card-->
            <div class="comments">
                <!--Comments-->
                <div class="card card-comments mb-3 wow fadeIn">
                    <div class="card-header font-weight-bold">{{ post_info.post_comments | length }} comments</div>
                    <div class="card-body">
                        {% for comment in post_info.post_comments %}
                        <div class="media d-block d-md-flex mt-4">
                            <div class="media-body text-center text-md-left ml-md-3 ml-0">
                                <h5 class="mt-0 font-weight-bold">{{ comment.comment_author_name }}
                                </h5>
                                <p class="small" style="color:#007bff;"><span class="fa fa-clock-o">
                                        {{ comment.comment_created_date }}</span></p>
                                <p>{{ comment.comment_content}}
                                    <span class="pull-right">
                                        <a class="vote-btn btn btn-success btn-xs"
                                            href="/post/vote?id={{ comment.comment_id }}&type=comment">
                                            <span class="fa fa-thumbs-up"> {{comment.comment_votes}}</span>
                                        </a>
                                        {% if user_info.id == post_info.post_author_id or user_info.id == comment.comment_author_id %}
                                        <a class="btn btn-danger btn-xs delete-btn"
                                            href="/post/uncomment?id={{ comment.comment_id }}">
                                            <span class="fa fa-trash"> Delete</span>
                                        </a>
                                        {% endif %}
                                    </span>
                                </p>

                            </div>
                        </div>
                        {% endfor %}
                    </div>
                </div>
                <!--/.Comments-->

                <!--Reply-->
                <div class="card mb-3 wow fadeIn">
                    <div class="card-header font-weight-bold">Leave a Comment</div>
                    <div class="card-body">

                        <!-- Default form reply -->
                        <form action="/post/comment" method="POST">

                            <!-- Comment -->
                            <div class="form-group">
                                <label for="replyFormComment">Your Comment</label>
                                <textarea name="comment_content" class="form-control" id="replyFormComment" rows="5"
                                    placeholder="Write Your Comment Here!" required></textarea>
                            </div>

                            <div class="text-center mt-4">
                                <input type="hidden" name="post_id" value="{{ post_info.post_id }}">
                                <button class="btn btn-info btn-md" type="submit"><span class="fa fa-paper-plane">
                                        Post</span></button>
                            </div>
                        </form>
                        <!-- Default form reply -->



                    </div>
                </div>
                <!--/.Reply-->
            </div>
        </div>
    </div>

</div>
{% endblock %}