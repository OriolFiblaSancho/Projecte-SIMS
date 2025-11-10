import { createMap } from './map.js';
import { createRandomMarkers, bottomBarToggle } from './markers.js';
import { attachUserLocationControl } from './userLocation.js';

const CENTER = { lat: 40.70922331914339, lng: 0.5771204885805513 };
const ZOOM = 15;
const MARKERS_COUNT = 10;
const RADIUS_MT_FROM_CENTER = 600;

export function initMap() {
  const map = createMap('map', CENTER, ZOOM);

  createRandomMarkers(map, CENTER, MARKERS_COUNT, RADIUS_MT_FROM_CENTER);
  bottomBarToggle(map);
  attachUserLocationControl(map)
    .locate({ desiredAccuracy: 30, maxWaitMs: 10000 })
    .catch((e) => {
      console.warn('Initial locate failed or timed out:', e);
    });
  // If a geofencing form with latitude/longitude inputs exists on the page,
  // enable clicking the map to fill them and show a temporary marker.
  try {
    const latInput = document.querySelector('input[name="center_latitude"]');
    const lngInput = document.querySelector('input[name="center_longitude"]');
    if (latInput && lngInput) {
      // lazy-import the helper from map module (available in same file)
      import('./map.js').then(mod => {
        if (mod.enableClickToFill) {
          // attach and keep cleanup on window for possible later use
          window.__enableClickToFillCleanup = mod.enableClickToFill(map, 'input[name="center_latitude"]', 'input[name="center_longitude"]');
        }
      }).catch(err => console.warn('Failed to attach map click handler', err));
    }
  } catch (err) {
    console.warn('initMap: error checking for geofencing inputs', err);
  }
  
}

window.initMap = initMap;
