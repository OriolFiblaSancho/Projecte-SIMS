/*
  Module: mapPicker
  Provides a function to enable a "pick on map" mode that lets the user
  click the map to choose coordinates and fills the form inputs.
*/

export function enableMapPicker(map) {
  if (!map) return;

  let pickMode = false;
  let selectionMarker = null;

  const pickButton = document.getElementById('pick-on-map');
  const latInput = document.getElementById('vehicle-latitude');
  const lngInput = document.getElementById('vehicle-longitude');

  function formatCoord(v) {
    return Number(v).toFixed(8);
  }

  if (pickButton && latInput && lngInput) {
    pickButton.addEventListener('click', () => {
      pickMode = !pickMode;
      pickButton.textContent = pickMode ? 'Cancel pick' : 'Pick on map';
      pickButton.classList.toggle('bg-yellow-100', pickMode);
      // Provide brief visual feedback on the placeholder map area
      const placeholder = document.getElementById('map-picker-placeholder');
      if (placeholder) {
        placeholder.classList.toggle('ring', pickMode);
        placeholder.classList.toggle('ring-2', pickMode);
        placeholder.classList.toggle('ring-yellow-300', pickMode);
      }
    });

    // Map click handler for selecting coordinates
    map.addListener('click', (ev) => {
      if (!pickMode) return;

      const lat = ev.latLng.lat();
      const lng = ev.latLng.lng();

      // Place or move a temporary marker
      if (selectionMarker) {
        selectionMarker.setPosition({ lat, lng });
      } else {
        selectionMarker = new google.maps.Marker({
          position: { lat, lng },
          map,
          title: 'Selected location',
        });
      }

      // Fill the readonly inputs
      latInput.value = formatCoord(lat);
      lngInput.value = formatCoord(lng);

      // Exit pick mode automatically after selection
      pickMode = false;
      pickButton.textContent = 'Pick on map';
      pickButton.classList.remove('bg-yellow-100');
      const placeholder = document.getElementById('map-picker-placeholder');
      if (placeholder) {
        placeholder.classList.remove('ring', 'ring-2', 'ring-yellow-300');
      }
    });
  }
}

export default enableMapPicker;
