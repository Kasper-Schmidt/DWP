// Hent modal-elementet
var modal = document.getElementById("myModal");

// Hent knappen, der åbner modalen
var btn = document.getElementById("myBtn");

// Hent <span>-elementet, der lukker modalen
var span = document.getElementsByClassName("close")[0];

// Når brugeren klikker på knappen, åbnes modalen
btn.onclick = function() {
    modal.style.display = "block";
}

// Når brugeren klikker på <span> (x), lukkes modalen
span.onclick = function() {
    modal.style.display = "none";
}

// Når brugeren klikker hvor som helst uden for modalen, lukkes den
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Lyt efter klik-hændelser på dokumentet
document.addEventListener("click", function (e) {
    // Hvis det klikkede element har klassen "gallery-item"
    if (e.target.classList.contains("gallery-item")) {
        // Hent kildeattributten (src) for det klikkede element
        const src = e.target.getAttribute("src");

        // Opdater kilden for billedet i modalen med den nye kilde
        document.querySelector(".modal-img").src = src;

        // Opret en ny bootstrap-modal og vis den
        const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
        myModal.show();
    }
});