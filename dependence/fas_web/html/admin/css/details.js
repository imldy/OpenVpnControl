var headoc = $(".float-auto");
var offset = headoc.offset().top;
var height = headoc.height();
var mtop = parseInt(headoc.css("margin-top"));
var status = 0;


$(function () {

    setFloat()
    $(window).scroll(function () {
        setFloat();
    });



    $(".post").click(function () {
        var content = $("textarea[name='content']").val();
        if (editor.isEmpty()) {
            alert("不能回复空内容哦！");
            return;
        }
        post_comment(content, post_id, 0, 0, function (data) {
            if (data.status == "success") {
                window.location.href = data.msg;
            } else {
                alert(data.msg);
            }
        });
    });


    $('.del').click(function () {
        if (confirm("确认删除此条内容？")) {
            var del = $(this).attr('href');
            $.post(del, {}, function (data) {
                if (data.status == "success") {
                    window.location.reload();
                } else {
                    alert(data.msg);
                }
            }, "JSON");
        }
        return false;
    });

    $('.op_to_top').click(function () {
        if (confirm("确认置顶/取消置顶此主题？")) {
            var del = $(this).attr('href');
            $.post(del, {}, function (data) {
                if (data.status == "success") {
                    window.location.reload();
                } else {
                    alert(data.msg);
                }
            }, "JSON");
        }
        return false;
    });
});

$(function () {
    var comment = $(".comment-reply .comment-reply-list");
    for (var i = 0; i < comment.length; i++) {
        load_reply(comment.eq(i).attr("data"));
    }

});

function bindPageEnv(elm,id){
    elm.find(".pagination-mini li a").click(function(){
        var href = $(this).attr("href");
        load_reply(id,href);
        return false;
    });
}
/*
*   加载评论
* */
function load_reply(id,href) {
    var url = href ? href : _LOAD_REPLY_URL_;
    $.post(url, {
        "id": id
    }, function (data) {
        var html = "";
        if (data.status == "success") {
            for (var i = 0; i < data.list.length; i++)
            {
                html += createHtml(data.list[i]);
            }
            $(".comment-box-" + id).show();
            var box = $(".re-id-" + id);
            box.html('<ul class="reply ul-nostyle">' + html + '</ul>' + data.page);
            bindPageEnv(box,id);
        }else{
            $(".comment-box-" + id).find(".comment-reply-form").show();
        }
    }, "JSON");
}
function setFloat() {
    var top = $(window).scrollTop();
    if (top >= offset) {
        if (status == 0) {
            var w = parseInt(headoc.outerWidth());
            status = 1;
            var nt = mtop + top - offset;
            headoc.css({"width": w + "px", "position": "fixed", "top": 0});
        }
    } else {
        status = 0;
        headoc.css({"width": "auto", "position": "static", "top": 0});
    }
}
function comment_submit(elm, id) {
    var comment_submit = $('.comment-submit');
    var comment_edit = $('.comment_edit');
    var n =comment_submit.index(elm);
    var content = de.getContent(comment_edit.eq(n)).trim();
    var to_uid = $(".hideValue" + id).find("[name='to_uid']").val();
    post_comment(content, post_id, id, to_uid, function (data) {
        if (data.status == "success") {
            comment_edit.eq(n).find("iframe").contents().find("body").html("");
            load_reply(id);
          //  bindPageEnv();
        } else {
            alert(data.msg);
        }
    });
}

function comment_this(toid, uid, nickname) {
    var elm = $("#pos-com-" + toid);
    $(".comment-box-" + toid + " .huifuwho").html("@" + nickname);
    $(".comment-box-" + toid + " .comment-reply-form").slideDown("fast");
    elm.find("iframe").blur();
    elm.find("iframe").contents().find("body").html("");
    elm.find("iframe").focus();
    $(".hideValue" + toid).find("[name='to_uid']").val(uid);
    return false;
}

function comment_cz(toid) {
    var elm = $("#pos-com-" + toid);
    var hide = $(".hideValue" + toid);
    var from = $(".comment-box-" + toid + " .comment-reply-form");
    if (hide.find("[name='to_uid']").val() == 0) {
        from.slideToggle("fast");
    } else {
        from.slideDown("fast")
    }
    $(".comment-box-" + toid + " .huifuwho").html("@层主");
    //elm.find("iframe").blur();
    elm.find("iframe").contents().find("body").html("");
    // elm.find("iframe").focus();
    hide.find("[name='to_uid']").val(0);
    return false;
}

function post_comment(content, p_id, t_id, t_uid, callback) {
    var add = _POST_COMMENT_URL_;
    $.post(add, {
        "do": "submit",
        "content": content,
        "post_id": p_id,
        "to_id": t_id,
        "to_uid": t_uid
    }, callback, "JSON");
}

function createHtml(data) {
    var html =
        '<li class="">' +
        '<img src="' + data.head + '"class="head "><div class="right">'
        + '<a href="">' + data.nickname + '</a>'
        + '：'
        + data.content +
        '<div class="time">'
        + data.time
        + ' | <a href="javascript:void(0)" onclick="comment_this(' +
        data.to_id + ',' + data.uid + ',' +
        "'" + data.nickname + "'"
        + ')">回复</a>'
        + '</div>' +
        '</div></li>';
    return html;
}

function toggleComment(id) {
    $(".comment-box-" + id).slideToggle("fast");
    return false;
}