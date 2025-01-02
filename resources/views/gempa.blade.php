<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #map { height: 600px; }
    </style>
     <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
    <body>
        <div style="text-align: center">
            <h1>PETA GEMPA BUMI</h1>
            <h3>Sumber Data dari BMKG</h3>
        </div>
        <div id="map"></div>
        <script>
            // Openstreetmap
            var map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{ maxZoom: 18,
              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // API Gempa BMKG
            let files = {!! file_get_contents("https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json") !!};
            console.log(files);

            // get data yg diinginkan
            let gempas = files.Infogempa.gempa;

            // looping data array object gempa
            gempas.forEach(gempas=> {
                let koordinat = gempas.Coordinates.split(",");
                let lat = koordinat[0];
                let log = koordinat[1];

                // marker
                let marker = L.marker([lat, log]).addTo(map);

                // Popup
                marker.bindPopup(
                    "Tanggal: " + gempas.Tanggal + "</br>" +
                    "Jam: " + gempas.Jam + "</br>" +
                    "Kekuatan: " + gempas.Magnitude + " SR" + "</br>" +
                    "Wilayah: " + gempas.Wilayah + "</br>" +
                    "Potensi: " + gempas.Potensi
                )
            });
        </script>
    </body>
</html>