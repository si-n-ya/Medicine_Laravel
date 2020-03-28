$(function() {
    "use strict";

    // ドロワー開閉
    $(".btn_hamburger").click(function() {
        let logo = $(this).find(".hamburger_logo");
        if ($(logo).hasClass("is_cancel_logo")) {
            $(".global_nav").removeClass("is_drower_active");
            $(".header")
                .removeClass("is_header_fixed")
                .removeClass("is_header_full_open");
            $(logo).removeClass("is_cancel_logo");
        } else {
            $(".global_nav").addClass("is_drower_active");
            $(".header")
                .addClass("is_header_fixed")
                .addClass("is_header_full_open");
            $(logo).addClass("is_cancel_logo");
        }
    });

    // formの'全ての曜日'をクリック時
    $(".week_dd").on("click", ".all_check", function() {
        if ($(".all_check").hasClass("all")) {
            $(".regist_week_check").prop("checked", "");
            $(".all_check").removeClass("all");
        } else {
            $(".regist_week_check").prop("checked", "checked");
            $(".all_check").addClass("all");
        }
    });

    // formの曜日をクリックした時に、'全ての曜日'のチェックが外れる
    $(".week_dd").on("click", ".regist_week_check", function() {
        $(".all_check").prop("checked", "");
        $(".all_check").removeClass("all");
    });

    // '全ての履歴'をクリック時
    $(".history_flex_box").on("click", ".all_check", function() {
        if ($(".all_check").hasClass("all")) {
            $(".history_check").prop("checked", "");
            $(".all_check").removeClass("all");
        } else {
            $(".history_check").prop("checked", "checked");
            $(".all_check").addClass("all");
        }
    });
    // 履歴をクリックした時に、'全ての履歴'のチェックが外れる
    $(".history_td").on("click", ".history_check", function() {
        $(".all_check").prop("checked", "");
        $(".all_check").removeClass("all");
    });

    $(".list_one").on("click", ".check", function() {
        let id = $(this)
            .parents(".list_one")
            .data("id");
        let time_id = $(this)
            .parents(".list_one")
            .data("time");
        let week_id = $(this)
            .parents(".list_one")
            .data("week");
        let date = $(this)
            .parents(".list_one")
            .data("date");
        let use_num = $(this)
            .parents(".list_one")
            .data("num");
        let class_done = $(this).parents(".list_one");

        if ($(class_done).hasClass("done")) {
            $.ajax({
                url: "/check",
                type: "post",
                dataTyoe: "json",
                data: {
                    id: id,
                    week_id: week_id,
                    time_id: time_id,
                    date: date,
                    use_num: use_num,
                    mode: "remove_check"
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            })
                .done(function() {
                    $(class_done).removeClass("done");
                })
                .fail(function(data) {
                    console.log(data);
                });
        } else {
            $.ajax({
                url: "/check",
                type: "post",
                dataTyoe: "json",
                data: {
                    id: id,
                    week_id: week_id,
                    time_id: time_id,
                    date: date,
                    use_num: use_num,
                    mode: "add_check"
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            })
                .done(function() {
                    $(class_done).addClass("done");
                })
                .fail(function(data) {
                    console.log(data);
                });
        }
    });
});
