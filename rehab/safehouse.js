function searchLocation() {
    const location = document.getElementById('location-input').value;
    const status = document.getElementById('status');
    const shelterList = document.getElementById('shelter-list');
    shelterList.innerHTML = ""; // Clear the list

    if (location === "") {
        status.textContent = "Please enter a location.";
        return;
    }

    status.textContent = "Searching for location…";

    // Use Nominatim API to geocode the location
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location)}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                status.textContent = "Location not found. Please try again.";
                return;
            }

            const lat = data[0].lat;
            const lon = data[0].lon;
            document.getElementById('status').textContent = `Latitude: ${lat}, Longitude: ${lon}`;

            // Initialize the map centered on the searched location
            const map = L.map('map').setView([lat, lon], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const userLocation = L.marker([lat, lon]).addTo(map)
                .bindPopup(location)
                .openPopup();

            // Call a function to get nearby shelters
            getNearbyShelters(lat, lon, map);
        })
        .catch(error => {
            status.textContent = "Error finding location.";
        });
}

function getNearbyShelters(lat, lon, map) {
    const shelterList = document.getElementById('shelter-list');

    // Define the Overpass API query to find shelters or emergency facilities
    const query = `[out:json];
    (
        node["amenity"="shelter"](around:5000, ${lat}, ${lon});
        node["amenity"="emergency"](around:5000, ${lat}, ${lon});
    );
    out body;`;

    fetch(`https://overpass-api.de/api/interpreter?data=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            const elements = data.elements;

            if (elements.length === 0) {
                shelterList.innerHTML = "<li>No nearby shelters found</li>";
                return;
            }

            elements.forEach(element => {
                const li = document.createElement('li');
                li.textContent = element.tags.name || "Unnamed Shelter";
                shelterList.appendChild(li);

                L.marker([element.lat, element.lon]).addTo(map)
                    .bindPopup(element.tags.name || "Unnamed Shelter")
                    .openPopup();
            });
        })
        .catch(error => {
            shelterList.innerHTML = "<li>Error fetching shelter data</li>";
        });
}

