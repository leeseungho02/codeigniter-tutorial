function showModal(el) {
    UIkit.modal(el).show();
}

function hideModal(el) {
    UIkit.modal(el).hide();
}

function ajax(url, type, data, successFn) {
    $.ajax({
        url: url,
        type: type,
        data: data,
        processData: false,
        contentType: false,
        success: successFn
    });
}

function createModal(title, table) {
    const el = document.createElement("div");
    el.id = "modal";
    el.setAttribute("uk-modal", "");
    el.innerHTML = `
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <form method="POST">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">${title}</h2>
                </div>
                <div class="uk-modal-body">
                    <input type="hidden" name="table" id="table" value="${table}">
                    <input type="password" name="pw" id="pw" class="uk-input" value="" placeholder="비밀번호를 입력해주세요.">
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">취소</button>
                    <button class="uk-button uk-button-primary" type="submit">확인</button>
                </div>
            </form>
        </div>
    `;

    document.body.appendChild(el);
}