document.querySelectorAll('.card').forEach((btn) => {
    btn.addEventListener("click", function() {
        window.location = `${this.id}`;
    });
});