//选项卡切换
function setTab(name, cursel, n) {
    for (i = 1; i <= n; i++) {
        var menu = document.getElementById(name + i);
        var con = document.getElementById("con_" + name + "_" + i);
        menu.className = i == cursel ? "active" : "";
        con.style.display = i == cursel ? "block" : "none";
    }
}
//模拟下拉菜单
$(document).ready(function () {
    $(".btn-select").click(function (event) {
        event.stopPropagation();
        $(this).find(".option").toggle();
        $(this).parent().siblings().find(".option").hide();
    });
    $(document).click(function (event) {
        var eo = $(event.target);
        if ($(".btn-select").is(":visible") && eo.attr("class") != "option" && !eo.parent(".option").length)
            $('.option').hide();
    });


    /*赋值给文本框*/
    $(".option a").click(function () {
        var value = $(this).text();
        $(this).parent().siblings(".select-txt").text(value);
        $("#select_value").val(value)
    });

    //Load selected data-list-id from cookie
    var current_page_order = $.cookie('current_page_order');
    var current_page_parent = $.cookie('current_page_parent');
    if (current_page_order != undefined && current_page_parent != undefined) {
        var query = "data-order=" + current_page_order;
        $('.sub-menu-' + current_page_parent).find("a[" + query + "]").addClass('submenu_selected');
    }

    //Set selected state in cookie when a is clicked
    var submenu_head = $('.sub-menu > li > a');
    submenu_head.on('click', function (event) {
        $.cookie('current_page_order', $(this).attr('data-order'), {expires: 10, path: "/"});
        $.cookie('current_page_parent', $(this).attr('data-order-parent'), {expires: 10, path: "/"});
    });

    // Store variables
    var accordion_head = $('.accordion > li > a'),
        accordion_body = $('.accordion li > .sub-menu');
    // Open the first tab on load
//        accordion_head.first().addClass('active').next().slideDown('normal');

    // Open selected tabs on load based on cookie value
    if(current_page_parent!=undefined){
        $('.sub-menu-'+current_page_parent).show();
    }else{
        accordion_head.first().next().show();
    }

    // Click function
    accordion_head.on('click', function (event) {
        // Disable header links
        event.preventDefault();
        // Show and hide the tabs on click
        if ($(this).attr('class') != 'active') {
            accordion_body.slideUp('normal');
            $(this).next().stop(true, true).slideToggle('normal');
            accordion_head.removeClass('active');
            $(this).addClass('active');
        }
    });


})
//媒体-轮播图片
$(function () {
    var sWidth = $("#focus").width();
    var len = $("#focus ul li").length;
    var index = 0;
    var picTimer;
    var btn = "<div class='btnBg'></div><div class='btn'>";
    for (var i = 0; i < len; i++) {
        btn += "<span></span>";
    }
    btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
    $("#focus").append(btn);
    $("#focus .btnBg").css("opacity", 0);
    $("#focus .btn span").css("opacity", 0.4).mouseenter(function () {
        index = $("#focus .btn span").index(this);
        showPics(index);
    }).eq(0).trigger("mouseenter");
    $("#focus .preNext").css("opacity", 0.0).hover(function () {
        $(this).stop(true, false).animate({ "opacity": "0.5" }, 300);
    }, function () {
        $(this).stop(true, false).animate({ "opacity": "0" }, 300);
    });
    $("#focus .pre").click(function () {
        index -= 1;
        if (index == -1) {
            index = len - 1;
        }
        showPics(index);
    });
    $("#focus .next").click(function () {
        index += 1;
        if (index == len) {
            index = 0;
        }
        showPics(index);
    });
    $("#focus ul").css("width", sWidth * (len));
    $("#focus").hover(function () {
        clearInterval(picTimer);
    },function () {
        picTimer = setInterval(function () {
            showPics(index);
            index++;
            if (index == len) {
                index = 0;
            }
        }, 2800);
    }).trigger("mouseleave");
    function showPics(index) {
        var nowLeft = -index * sWidth;
        $("#focus ul").stop(true, false).animate({ "left": nowLeft }, 300);
        $("#focus .btn span").stop(true, false).animate({ "opacity": "0.4" }, 300).eq(index).stop(true, false).animate({ "opacity": "1" }, 300);
    }
});