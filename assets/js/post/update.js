const form = document.querySelector(".form");
const deleteFileBtns = document.querySelectorAll(".deleteFileBtn");
const deleteFileInput = document.querySelector("#deleteFileInput");
const deleteFileArray = [];

for (let i = 0; i < deleteFileBtns.length; i++) {
    const deleteFileBtn = deleteFileBtns[i];
    deleteFileBtn.addEventListener("click", function (e) {
        const target = e.currentTarget;
        const dom = target.parentElement;
        dom.remove();
        deleteFileArray.push(deleteFileBtns[i].dataset.id);
    });
}


form.addEventListener("submit", (e) => {
    deleteFileInput.value = JSON.stringify(deleteFileArray);
});