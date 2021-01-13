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