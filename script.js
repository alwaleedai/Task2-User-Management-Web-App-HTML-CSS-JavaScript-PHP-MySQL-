document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("usersTable");

    table.addEventListener("click", function (e) {
        if (e.target.classList.contains("toggle-btn")) {
            const btn = e.target;
            const id = btn.dataset.id;

            btn.disabled = true;

            fetch("toggle.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + encodeURIComponent(id)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById("row-" + id);
                        const statusCell = row.querySelector(".status-cell");
                        statusCell.textContent = data.new_status;
                    } else {
                        alert("خطأ: " + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("حدث خطأ أثناء الاتصال بالسيرفر");
                })
                .finally(() => {
                    btn.disabled = false;
                });
        }
    });
});
