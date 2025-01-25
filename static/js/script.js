let scanner;

function startScanner() {
    scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

    scanner.addListener('scan', function (content) {
        fetch('/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ code: content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                document.getElementById("loginForm").action = data.redirect;
                document.getElementById("loginForm").submit();
            } else {
                alert("Error: " + (data.error || "Unknown error"));
            }
        })
        .catch(error => console.error('Error:', error));

        scanner.stop();
        document.querySelector(".qr-detected-container").style.display = "block";
        document.querySelector(".viewport").style.display = "none";
    });

    Instascan.Camera.getCameras()
        .then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        })
        .catch(function (err) {
            console.error('Camera access error:', err);
            alert('Camera access error: ' + err);
        });
}

document.addEventListener('DOMContentLoaded', startScanner);
