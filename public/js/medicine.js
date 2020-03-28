(function() {
    "use strict";

    let del_btn = document.getElementsByClassName("delete_btn");

    // list_delete というクラス名があるとき
    if (del_btn[0].classList.contains("list_delete")) {
        let del_btn = document.getElementsByClassName("list_delete");
        for (let i = 0; i < del_btn.length; i++) {
            del_btn[i].addEventListener("click", function(e) {
                e.preventDefault();
                if (confirm("本当に削除しますか？")) {
                    document.getElementById("form_" + this.dataset.id).submit();
                }
            });
        }
        // history_delete というクラス名があるとき
    } else if (del_btn[0].classList.contains("history_delete")) {
        let history_delete = document.getElementsByClassName("history_delete");

        history_delete[0].addEventListener("click", function(e) {
            e.preventDefault();
            if (confirm("本当に削除しますか？")) {
                document.delete_form.submit();
            }
        });
    }
})();
