function adminFilter(status) {
    let elems = document.getElementsByClassName("request-row");
    for (let i = 0; i < elems.length; i++) {
        if (elems[i].dataset.status == status || status == "all") {
            elems[i].style.display = "table-row";
        } else {
            elems[i].style.display = "none";
        }
    }
}
