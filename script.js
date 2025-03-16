function daftarHadir() {
    let nama = document.getElementById("nama").value.trim();
    let nomorWa = document.getElementById("nomorWa").value.trim();

    if (nama === "" || nomorWa === "") {
        alert("Mohon isi semua data!");
        return;
    }

    fetch("server.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `nama=${encodeURIComponent(nama)}&nomor_wa=${encodeURIComponent(nomorWa)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(`Berhasil! Anda membaca Juz ${data.juz}`);
            window.open(data.wa_link, "_blank");
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}

function resetList() {
    let password = prompt("Masukkan password untuk reset:");
    fetch("server.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `reset=true&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => alert(data.message))
    .catch(error => console.error("Error:", error));
}
