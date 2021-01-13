function updateModal(dom) {
    showModal('#modal');
    const form = document.querySelector('#modal form');
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        ajax("/index.php/post/writerCheck", "POST", formData, function (data) {
            data = JSON.parse(data);
            if (data) {
                dom.querySelector(".d-none").classList.remove("d-none");
                dom.querySelector(".view").classList.add("d-none");
                form.reset();
                hideModal('#modal');
            } else {
                alert("비밀번호가 틀리셨습니다.");
            }
        });
    });
}

document.querySelectorAll(".commentUpdateLink").forEach(el => {
    el.addEventListener("click", (e) => {
        e.preventDefault();

        const target = e.currentTarget;
        const writer = target.dataset.writer;
        const parent = target.parentElement.parentElement.parentElement;

        if (member) {
            // 해당 작성자 회원인지 체크
            if (writer != member.id) {
                alert("해당 작성자만 수정 삭제 가능합니다.");
                return;
            } else {
                parent.querySelector(".d-none").classList.remove("d-none");
                parent.querySelector(".view").classList.add("d-none");
            }
        } else {
            // 회원이 아닐 때 비회원의 댓글인지 체크
            if (writer == 0) {
                updateModal(parent);
                return;
            } else {
                alert("해당 작성자만 수정 삭제 가능합니다.");
                return;
            }
        }
    });
});

function deleteModal(url) {
    showModal('#modal');
    const form = document.querySelector('#modal form');
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        ajax("/index.php/post/writerCheck", "POST", formData, function (data) {
            data = JSON.parse(data);
            if (data) {
                form.reset();
                window.location.href = url;
            } else {
                alert("비밀번호가 틀리셨습니다.");
            }
        });
    });
}

document.querySelectorAll(".commentDeleteLink").forEach(el => {
    el.addEventListener("click", (e) => {
        e.preventDefault();

        const target = e.currentTarget;
        const writer = target.dataset.writer;
        const url = target.dataset.url;

        if (member) {
            // 해당 작성자 회원인지 체크
            if (writer != member.id) {
                alert("해당 작성자만 수정 삭제 가능합니다.");
                return;
            } else {
                window.location.href = url;
            }
        } else {
            // 회원이 아닐 때 비회원의 댓글인지 체크
            if (writer == 0) {
                deleteModal(url);
                return;
            } else {
                alert("해당 작성자만 수정 삭제 가능합니다.");
                return;
            }
        }
    });
});

document.querySelectorAll(".postLink").forEach(el => {
    el.addEventListener("click", postListClick);
});

function postListClick(e) {
    const target = e.currentTarget;
    const writer = target.dataset.writer;
    const url = target.dataset.url;

    if (member) {
        // 해당 작성자 회원인지 체크
        if (writer != member.id) {
            alert("해당 작성자만 수정 삭제 가능합니다.");
            return;
        } else {
            window.location.href = url;
        }
    } else {
        // 회원이 아닐 때 비회원의 댓글인지 체크
        if (writer == 0) {
            showModal('#modal');
            const form = document.querySelector('#modal form');
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                ajax("/index.php/post/writerCheck", "POST", formData, function (data) {
                    data = JSON.parse(data);
                    if (data) {
                        form.reset();
                        window.location.href = url;
                    } else {
                        alert("비밀번호가 틀리셨습니다.");
                    }
                });
            });
        } else {
            alert("해당 작성자만 수정 삭제 가능합니다.");
            return;
        }
    }
}