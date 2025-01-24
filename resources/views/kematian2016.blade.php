<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Kematian 2016</title>

    {{-- Import Link Leaflet JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Link Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Link JS Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #map { height: 600px; }

        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            border-radius: 5px;
        }
        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }
        .legend {
            line-height: 18px;
            color: #555;
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
        footer{
            text-align: center;
            background-color: #555;
            color: white;
            padding: 8px 0;
        }
        footer p{
            margin:0;
            font-weight: 100;
            font-size: 0.8rem;
        }
        footer p a{
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{route('get_kotabogor')}}">Peta Kota Bogor</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              {{-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li> --}}
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Tahun Data Kematian
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{route('get_kematian2016')}}">2016</a></li>
                  <li><a class="dropdown-item" href="{{route('get_kematian2017')}}">2017</a></li>
                  <li><a class="dropdown-item" href="{{route('get_kematian2018')}}">2018</a></li>
                  <li><a class="dropdown-item" href="{{route('get_kematian2019')}}">2019</a></li>
                  <li><a class="dropdown-item" href="{{route('get_kematian2020')}}">2020</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div id="map"></div>
    <footer>
        <p>Dibuat oleh Kelompok Mahasiswa <a href="https://nurulfikri.ac.id/" target="_blank">STT Terpadu Nurulf Fikri</a></p>
        <p>Mata Kuliah Sistem Informasi Geografis 2024/2025</p>
    </footer>
    
    <script>
        // default peta Kota Bogor
        var map = L.map('map').setView([-6.59167, 106.8], 12);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{ maxZoom: 18,
              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

        // console.log(@json($bogor));
        
        const kotabogor = @json($bogor);

        const kotabogorData = kotabogor.map(kematian_2016 =>({
            type: "Feature",
            properties: {
                name: kematian_2016.name,
                id: kematian_2016.id,
                alt_name: kematian_2016.alt_name,
                population: kematian_2016.population,
                luas_wilayah: kematian_2016.luas_wilayah,
                kematian: kematian_2016.kematian,
                latitude: kematian_2016.latitude,
                longitude: kematian_2016.longitude
            },
            geometry: {
                type: kematian_2016.type_polygon,
                coordinates: JSON.parse(kematian_2016.polygon),
            }
        }));

        const geoJson = {
            type: "FeatureCollection",
            features: kotabogorData,
        }

        function getColor(d) {
            return d > 1050 ? '#8E1616' :
                d > 1000  ? '#F93827' :
                d > 900  ? '#E31A1C' :
                d > 800  ? '#FC4E2A' :
                d > 500  ? '#FD8D3C' :
                d > 450  ? '#FEB24C' :
                d > 300   ? '#FED976' :
                            '#2A004E';
        }

        function style(feature) {
            return {
                fillColor: getColor(feature.properties.kematian),
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.9
            };
        }

        function highlightFeature(e) {
            var layer = e.target;

            layer.setStyle({
                weight: 1,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });

            layer.bringToFront();
            info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }

        geojson = L.geoJson(geoJson, {style: style, onEachFeature: onEachFeature}).addTo(map);

        var info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };

        // method that we will use to update the control based on feature properties passed
        info.update = function (props) {
            this._div.innerHTML = '<h4>Data Kematian Kota Bogor 2016</h4>' +  (props ?
                '<b>' + props.name + '</b><br />' + 'Meninggal: '+props.kematian.toLocaleString('id-ID') + ' Jiwa'
                + '</b><br />' + 'Populasi: ' + props.population.toLocaleString('id-ID') + ' Jiwa'
                + '</b><br />' + 'Luas Wilayah: ' + props.luas_wilayah + ' Km'
                + '</b><br />' + 'Latitude: ' + props.latitude
                + '</b><br />' + 'Longitude: ' + props.longitude
                : 'Hover over a state');
        };

        info.addTo(map);

        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {

            var div = L.DomUtil.create('div', 'info legend'),
                grades = [0, 300, 450, 500, 800, 900, 1000, 1050],
                labels = [];
                
            // loop through our density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < grades.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                    grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }

            return div;
        };

        legend.addTo(map);
    </script>
</body>
</html>