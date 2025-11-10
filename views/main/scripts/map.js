import { createCenterMarker } from './markers.js';

export function createMap(elementId, center, zoom) {
  const minimalGreenStyle = [
    { elementType: 'geometry', stylers: [{ color: '#f5f5f4' }] },
    { elementType: 'labels.icon', stylers: [{ visibility: 'off' }] },
    { elementType: 'labels.text.fill', stylers: [{ color: '#616161' }] },
    { elementType: 'labels.text.stroke', stylers: [{ color: '#f5f5f4' }] },
    { featureType: 'road', elementType: 'geometry', stylers: [{ color: '#e9e9e6' }] },
    { featureType: 'road', elementType: 'geometry.stroke', stylers: [{ color: '#dededb' }] },
    { featureType: 'road', elementType: 'labels.text.fill', stylers: [{ color: '#9e9e9e' }] },
    { featureType: 'poi', stylers: [{ visibility: 'off' }] },
    { featureType: 'transit', stylers: [{ visibility: 'off' }] },
    { featureType: 'poi.park', elementType: 'geometry', stylers: [{ color: '#CAF0D8' }] },
    { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#e8f6f0' }] }
  ];

  const map = new google.maps.Map(document.getElementById(elementId), {
    center,
    zoom,
    //minZoom: zoom - 1,
    maxZoom: zoom + 3,
    styles: minimalGreenStyle,
    disableDefaultUI: true,
    zoomControl: false,
    gestureHandling: 'greedy'
  });

  return map;
}

/**
 * Enable clicking on the map to fill latitude/longitude inputs and show a marker.
 * @param {google.maps.Map} map
 * @param {string} latSelector - CSS selector for latitude input (e.g. 'input[name="center_latitude"]')
 * @param {string} lngSelector - CSS selector for longitude input
 * @returns {function} cleanup function to remove marker
 */
export function enableClickToFill(map, latSelector, lngSelector) {
  if (!map) return () => {};
  let clickMarker = null;

  const listener = map.addListener('click', (e) => {
    const lat = e.latLng.lat();
    const lng = e.latLng.lng();

    try {
      const latEl = document.querySelector(latSelector);
      const lngEl = document.querySelector(lngSelector);
      if (latEl) latEl.value = Number(lat).toFixed(6);
      if (lngEl) lngEl.value = Number(lng).toFixed(6);
    } catch (err) {
      // ignore if document not ready or selectors not present
      console.warn('enableClickToFill: could not set inputs', err);
    }

    if (clickMarker) {
      clickMarker.setPosition(e.latLng);
    } else {
      clickMarker = new google.maps.Marker({ position: e.latLng, map });
    }
  });

  return () => {
    if (clickMarker) clickMarker.setMap(null);
    if (listener) listener.remove();
  };
}
