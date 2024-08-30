const precautions = {
    earthquake: [
        "Drop, cover, and hold on.",
        "Secure heavy items to walls.",
        "Create an emergency kit with food, water, and medical supplies."
    ],
    flood: [
        "Move to higher ground immediately.",
        "Avoid walking or driving through floodwaters.",
        "Disconnect electrical appliances."
    ],
    fire: [
        "Install smoke detectors and check them regularly.",
        "Keep a fire extinguisher nearby.",
        "Create and practice an escape plan."
    ],
    hurricane: [
        "Board up windows and secure outdoor objects.",
        "Evacuate if advised by authorities.",
        "Have an emergency supply kit ready."
    ],
    tornado: [
        "Seek shelter in a basement or an interior room without windows.",
        "Avoid windows and cover your head.",
        "Listen to weather alerts and follow instructions."
    ]
};

function searchPrecautions() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = '';

    if (precautions[query]) {
        precautions[query].forEach(precaution => {
            const div = document.createElement('div');
            div.classList.add('result-item');
            div.textContent = precaution;
            resultsContainer.appendChild(div);
        });
    } else {
        const noResultDiv = document.createElement('div');
        noResultDiv.classList.add('result-item');
        noResultDiv.textContent = "No precautions found for this disaster.";
        resultsContainer.appendChild(noResultDiv);
    }
}
