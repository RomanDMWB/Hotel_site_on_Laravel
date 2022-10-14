const selectTypes = document.getElementById("types");
const selectPlaces = document.getElementById("places");

selectTypes.addEventListener("change", (e) => {
    fetch("http://localhost:8000/admin/booking/type/" + selectTypes.value, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((json) => {
            while (selectPlaces.hasChildNodes()) {
                selectPlaces.removeChild(selectPlaces.lastChild);
            }
            json.places.forEach((place) => {
                const option = document.createElement("option");
                option.value = place.number;
                option.textContent = place.number;
                selectPlaces.append(option);
            });
        });
});
