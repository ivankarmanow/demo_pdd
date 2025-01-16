document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("ts").addEventListener("input", (e) => {
        e.target.value = e.target.value.toUpperCase();
        e.target.value = e.target.value.replace(/([А-Я])(\d)/g, '$1 $2')
            .replace(/(\d)([А-Я])/g, '$1 $2');
    });

    document.querySelector("form").addEventListener("submit", (e) => {
        e.target.classList.add("was-validated");
        if (!e.target.checkValidity()) {
            e.stopPropagation();
            e.preventDefault();
        }
    })
});