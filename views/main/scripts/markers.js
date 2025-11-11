const svg = `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(
  `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0D6344" class="size-6">
    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
  </svg>`
)}`;
const svg2 = `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(
  `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#7E3FBC" class="size-6">
    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
  </svg>`
)}`;
const svg3 = `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(
  `<svg width="800px" height="800px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M8 4C5.79086 4 4 5.79086 4 8C4 10.2091 5.79086 12 8 12C10.2091 12 12 10.2091 12 8C12 5.79086 10.2091 4 8 4ZM6 8C6 6.89543 6.89543 6 8 6C9.10457 6 10 6.89543 10 8C10 9.10457 9.10457 10 8 10C6.89543 10 6 9.10457 6 8Z" fill="#0D6344"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 0 8 0ZM2 8C2 4.68629 4.68629 2 8 2C11.3137 2 14 4.68629 14 8C14 11.3137 11.3137 14 8 14C4.68629 14 2 11.3137 2 8Z" fill="#0D6344"/>
</svg>`
)}`;

const SELECTED = document.getElementById('selectedCarInfo');
const BOTTOM = document.getElementById('bottomBar');
let lastMarker;


// ===== NOU CODI =====
// Aquesta funció controla la visibilitat de la barra
function handleBarVisibility() {
  const isDesktop = window.matchMedia('(min-width: 768px)').matches;
  const isBarExpanded = BOTTOM.classList.contains('expanded');

  if (isDesktop) {
    // Si som a ESCRIPTORI
    if (isBarExpanded) {
      // i la barra està oberta (mostrant info), la deixem 'flex'
      BOTTOM.style.display = 'flex';
    } else {
      // i la barra està tancada, l'amaguem
      BOTTOM.style.display = 'none';
    }
  } else {
    // Si som a MÒBIL
    // Sempre la mostrem (per al botó QR)
    BOTTOM.style.display = 'flex';
  }
}

// S'executa al carregar la pàgina
handleBarVisibility();

// I s'executa CADA COP que es canvia la mida de la finestra
window.addEventListener('resize', handleBarVisibility);
// ===== FI NOU CODI =====


function toggleActiveMarker(marker) {
  if (!marker) return;

  if (lastMarker && lastMarker !== marker) {
    lastMarker.setIcon({ url: svg, scaledSize: new google.maps.Size(32, 32), anchor: new google.maps.Point(14, 28) });
  }

  const isActive = marker.icon && marker.icon.url === svg2;

  if (isActive) {
    marker.setIcon({ url: svg, scaledSize: new google.maps.Size(32, 32), anchor: new google.maps.Point(14, 28) });
    lastMarker = null;
  } else {
    const size = 42;
    marker.setIcon({ url: svg2, scaledSize: new google.maps.Size(42, 42), anchor: new google.maps.Point(Math.round(size / 2) - 1, size) });
    lastMarker = marker;
  }
}


function randomPointAround(centerLatLng, radiusMeters) {
  const radiusInDegrees = radiusMeters / 111320; // approx conversion
  const u = Math.random();
  const v = Math.random();
  const w = radiusInDegrees * Math.sqrt(u);
  const t = 2 * Math.PI * v;
  const dx = w * Math.cos(t);
  const dy = w * Math.sin(t);
  const newLat = centerLatLng.lat + dy;
  const newLng = centerLatLng.lng + dx / Math.cos(centerLatLng.lat * Math.PI / 180);
  return { lat: newLat, lng: newLng };
}

export function createCenterMarker(map, center) {
  return new google.maps.Marker(
    {
      position: center,
      map,
      icon: {
        url: svg, scaledSize: new google.maps.Size(50, 50),
        anchor: new google.maps.Point(25, 50)
      }
    });
}

export function createRandomMarkers(map, center, count, radiusMeters) {
  const markers = [];;
  for (let i = 0; i < count; i++) {
    const p = randomPointAround(center, radiusMeters);
    const m = new google.maps.Marker({
      position: p,
      map,
      icon: {
        url: svg, scaledSize: new google.maps.Size(32, 32),
        anchor: new google.maps.Point(14, 28)
      },
      title: `Point ${i + 1}`
    });

    //Expand
    m.addListener('click', () => {
      if (m == lastMarker) return;
      BOTTOM.classList.add('sliding-down');

      // Forcem la barra a 'flex' (per mostrar-la a escriptori)
      BOTTOM.style.display = 'flex';

      setTimeout(() => {
        BOTTOM.classList.add('expanded'); // <-- Li diem que està oberta
        SELECTED.classList.add('grid');
        SELECTED.classList.remove('hidden'); 
        BOTTOM.classList.remove('sliding-down');
        BOTTOM.classList.remove('get-up');
        toggleActiveMarker(m);
      }, 200);
    });

    markers.push(m);
  }
  return markers;
}

export function bottomBarToggle(map) {
  // Collapse on map click
  map.addListener('click', () => {

    if (BOTTOM.classList.contains('expanded')) {
      BOTTOM.classList.add('sliding-down');
      setTimeout(() => {
        SELECTED.classList.remove('grid');
        SELECTED.classList.add('hidden'); 
        BOTTOM.classList.remove('sliding-down');
        BOTTOM.classList.remove('expanded'); // <-- Li diem que s'ha tancat
        BOTTOM.classList.remove('get-up');

        // MODIFICAT: Cridem a la funció principal
        // Aquesta funció decidirà si s'ha d'amagar (escriptori) o no (mòbil)
        handleBarVisibility(); 
        
        toggleActiveMarker(lastMarker);
      }, 200);
    }
  });

  // Collapse when clicking outside the BOTTOM bar
  document.addEventListener('click', (e) => {
    const target = e.target;
    if (!target.closest('.not-collapse-bottom') && !BOTTOM.contains(target) && !target.closest('.gm-style')) {
      BOTTOM.classList.add('sliding-down');

      setTimeout(() => {
        SELECTED.classList.remove('grid');
        SELECTED.classList.add('hidden'); 
        BOTTOM.classList.remove('sliding-down');
        BOTTOM.classList.remove('expanded'); // <-- Li diem que s'ha tancat

        // MODIFICAT: Cridem a la funció principal
        handleBarVisibility();

      }, 200);
      toggleActiveMarker(lastMarker);
    }
  });
}
// Geofencing functions
export function getZonesCoordinates() {
  const rows = document.querySelectorAll('tbody tr:not(:has(td[colspan]))');

  const zones = Array.from(rows).map(row => {
    const nameCell = row.cells[0];
    const radiusCell = row.cells[2];
    const coordCell = row.cells[3];

    if (!nameCell || !radiusCell || !coordCell) return null;

    const name = nameCell.textContent.trim();
    const radius = parseFloat(radiusCell.textContent.trim());
    const [lat, lng] = coordCell.textContent.trim().split(',').map(s => parseFloat(s.trim()));

    return { name, lat, lng, radius };
  }).filter(Boolean);

  return zones;
}

export function paintCoords(map, zones) {
  // Clear existing markers and circles if needed
  if (window.markers) {
    window.markers.forEach(marker => marker.setMap(null));
  }
  if (window.circles) {
    window.circles.forEach(circle => circle.setMap(null));
  }
  window.markers = [];
  window.circles = [];

  zones.forEach(({ name, lat, lng, radius }) => {
    const position = { lat, lng };

    // Create marker
    const marker = new google.maps.Marker({
      icon: {
        url: svg3, scaledSize: new google.maps.Size(32, 32),
        anchor: new google.maps.Point(16, 16)
      },
      position,
      map,
    });
    window.markers.push(marker);

    // Create info window with zone name
    const infoWindow = new google.maps.InfoWindow({
      content: `<strong>${name}</strong><br>Radius: ${radius} meters`,
    });

    // Show info window on marker click
    marker.addListener('click', () => {
      infoWindow.open(map, marker);
    });

    // Draw circle with radius
    const circle = new google.maps.Circle({
      strokeColor: '#0D6344',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#8becc4ff',
      fillOpacity: 0.35,
      map,
      center: position,
      radius, // meters
    });
    window.circles.push(circle);
  });
  
  
}