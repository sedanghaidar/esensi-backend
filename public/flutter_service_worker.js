'use strict';
const MANIFEST = 'flutter-app-manifest';
const TEMP = 'flutter-temp-cache';
const CACHE_NAME = 'flutter-app-cache';
const RESOURCES = {
  "version.json": "cba95b38a75d11f7b4af72c36a11fd54",
"index.html": "4fd2c38ef5872321747e6603ccd6e29d",
"/": "4fd2c38ef5872321747e6603ccd6e29d",
"main.dart.js": "9fc018808bec8d946f57f5abe26ac158",
"favicon.png": "ceb532e0840acf3d94a7e252886e2c91",
"icons/icon_white.png": "50ab65e9a86b83251f3827cf0dd864a1",
"icons/Icon-192.png": "5886d763c7ea11732f5526ed22d6d78a",
"icons/Icon-maskable-192.png": "5886d763c7ea11732f5526ed22d6d78a",
"icons/Icon-maskable-512.png": "1df1d03733048259bfe11c4e829750e9",
"icons/Icon-512.png": "1df1d03733048259bfe11c4e829750e9",
"manifest.json": "7f68a5d9f17065b782ea077522819037",
"assets/AssetManifest.json": "3ad40826efbbefd72b5c48be10a418ba",
"assets/NOTICES": "390677ed8e3f03742f2955a7afb9910f",
"assets/FontManifest.json": "dc3d03800ccca4601324923c0b1d6d57",
"assets/packages/cupertino_icons/assets/CupertinoIcons.ttf": "6d342eb68f170c97609e9da345464e5e",
"assets/packages/quill_html_editor/assets/delete_row.png": "3a56332918794e49ffca20016948553d",
"assets/packages/quill_html_editor/assets/insert_column_left.png": "114e6cca4b2f60a5eaebe4e574f2c36d",
"assets/packages/quill_html_editor/assets/insert_table.png": "c8f041a07bc6b8e4010ccf93ba4c291d",
"assets/packages/quill_html_editor/assets/h1_dark.png": "aa135c261ba758a3990d4594d982104d",
"assets/packages/quill_html_editor/assets/insert_row_above.png": "80ae3856d5f7415d9957d9a1699ec782",
"assets/packages/quill_html_editor/assets/insert_column_right.png": "fb27c4e3cc557089f79dd1f0cc937d62",
"assets/packages/quill_html_editor/assets/insert_row_below.png": "cea46607b37038f71c0fec22341b80e4",
"assets/packages/quill_html_editor/assets/camera_roll_icon.png": "962f1d57cab7451d4b92b236b1993bd5",
"assets/packages/quill_html_editor/assets/delete_column.png": "62358bf5aa9ac7f18e2411e4a0c63f14",
"assets/packages/quill_html_editor/assets/delete_table.png": "37e148071ce0a306a27f296369e52f40",
"assets/packages/quill_html_editor/assets/edit_table.png": "6a51397f56e90d98ae0b46a2e359676f",
"assets/packages/quill_html_editor/assets/h2_dark.png": "037de75dfed94244b78e7493c6425586",
"assets/packages/magic_view/assets/eye_off.png": "d9c50f98fca48f44c8bc4dd6bf657ca5",
"assets/packages/magic_view/assets/eye.png": "bc6f7ace2e01ef3d0871ce98644e45a0",
"assets/fonts/MaterialIcons-Regular.otf": "e7069dfd19b331be16bed984668fe080",
"assets/assets/img_login.png": "03a6909845b9783d23cb6c0f8004af71",
"assets/assets/add_image.png": "d5125516ba6d03639dbda5643efd2e84",
"assets/assets/qrscan_error.png": "cb2686aae97fc3cc31e27e90a66a1d29",
"assets/assets/qrcode.png": "5335637c4502b41b13650bac44ea3a6c",
"assets/assets/img_warning.svg": "d57d87dd2812390230adc2a9166e8c2c",
"assets/assets/img_not_found.svg": "228e4ee9247e1cceb504ad2281f14458",
"assets/assets/ic_delete.png": "405f69800f0835776be71c86618182e0",
"assets/assets/ic_limited.png": "b79b4f7c5e7e0f05c76ca5942e586db5",
"assets/assets/eye_off.png": "d9c50f98fca48f44c8bc4dd6bf657ca5",
"assets/assets/img_login.svg": "e999c176809684ebc36847130a61d191",
"assets/assets/ic_date_close.png": "5672605245e03c671709037ffb8d51ab",
"assets/assets/ic_type_form.png": "3e2ee2b25f898fa2973952697c0e009d",
"assets/assets/office.png": "a451f9eb99eb328834db261461d45fe8",
"assets/assets/esensi/logo.png": "355798a54fd88b6a45eb4b9af1acbe7c",
"assets/assets/esensi/name.png": "cdf729efeff2e851782436c32c5efe8d",
"assets/assets/ic_qrcode_scanned.png": "8ead3dad044f539ebf7031fc333d53b9",
"assets/assets/qrscan_success.png": "69e9268f018acffc3d7d936631851e07",
"assets/assets/eye.png": "bc6f7ace2e01ef3d0871ce98644e45a0",
"assets/assets/ic_white_horizontal.png": "c251f6a1dd7423d83d54ea8fcc984432",
"assets/assets/ic_date.png": "8461ccb9a7c19150183fe3cc59958960",
"assets/assets/logo_jateng.svg": "13b67a2c507205bfa6cb82484615c159",
"assets/assets/ic_place.png": "f490ecac149b5c233b46a096b38e6860",
"assets/assets/participant.png": "00c39653c328aca113a5c57030a05875",
"assets/assets/img_jateng.png": "6bb3da6af024dc9c9ba61affb410ce7e",
"assets/assets/ic_qrcode.png": "f3a545c6fb8279be9188d2f7e07a08fc",
"assets/assets/ic_user_limit.png": "f1a6ba6527c3496abaed3179eaf39013",
"assets/assets/signature.png": "040b1f53ffe4b865ea2058fa654f04d9",
"assets/assets/img_error.svg": "9f9ad50373e1ac230bb5aa3a97d41cc9",
"assets/assets/ic_participant.png": "390f4c577d629b621c8e925e69ce47fe"
};

// The application shell files that are downloaded before a service worker can
// start.
const CORE = [
  "main.dart.js",
"index.html",
"assets/AssetManifest.json",
"assets/FontManifest.json"];
// During install, the TEMP cache is populated with the application shell files.
self.addEventListener("install", (event) => {
  self.skipWaiting();
  return event.waitUntil(
    caches.open(TEMP).then((cache) => {
      return cache.addAll(
        CORE.map((value) => new Request(value, {'cache': 'reload'})));
    })
  );
});

// During activate, the cache is populated with the temp files downloaded in
// install. If this service worker is upgrading from one with a saved
// MANIFEST, then use this to retain unchanged resource files.
self.addEventListener("activate", function(event) {
  return event.waitUntil(async function() {
    try {
      var contentCache = await caches.open(CACHE_NAME);
      var tempCache = await caches.open(TEMP);
      var manifestCache = await caches.open(MANIFEST);
      var manifest = await manifestCache.match('manifest');
      // When there is no prior manifest, clear the entire cache.
      if (!manifest) {
        await caches.delete(CACHE_NAME);
        contentCache = await caches.open(CACHE_NAME);
        for (var request of await tempCache.keys()) {
          var response = await tempCache.match(request);
          await contentCache.put(request, response);
        }
        await caches.delete(TEMP);
        // Save the manifest to make future upgrades efficient.
        await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
        return;
      }
      var oldManifest = await manifest.json();
      var origin = self.location.origin;
      for (var request of await contentCache.keys()) {
        var key = request.url.substring(origin.length + 1);
        if (key == "") {
          key = "/";
        }
        // If a resource from the old manifest is not in the new cache, or if
        // the MD5 sum has changed, delete it. Otherwise the resource is left
        // in the cache and can be reused by the new service worker.
        if (!RESOURCES[key] || RESOURCES[key] != oldManifest[key]) {
          await contentCache.delete(request);
        }
      }
      // Populate the cache with the app shell TEMP files, potentially overwriting
      // cache files preserved above.
      for (var request of await tempCache.keys()) {
        var response = await tempCache.match(request);
        await contentCache.put(request, response);
      }
      await caches.delete(TEMP);
      // Save the manifest to make future upgrades efficient.
      await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
      return;
    } catch (err) {
      // On an unhandled exception the state of the cache cannot be guaranteed.
      console.error('Failed to upgrade service worker: ' + err);
      await caches.delete(CACHE_NAME);
      await caches.delete(TEMP);
      await caches.delete(MANIFEST);
    }
  }());
});

// The fetch handler redirects requests for RESOURCE files to the service
// worker cache.
self.addEventListener("fetch", (event) => {
  if (event.request.method !== 'GET') {
    return;
  }
  var origin = self.location.origin;
  var key = event.request.url.substring(origin.length + 1);
  // Redirect URLs to the index.html
  if (key.indexOf('?v=') != -1) {
    key = key.split('?v=')[0];
  }
  if (event.request.url == origin || event.request.url.startsWith(origin + '/#') || key == '') {
    key = '/';
  }
  // If the URL is not the RESOURCE list then return to signal that the
  // browser should take over.
  if (!RESOURCES[key]) {
    return;
  }
  // If the URL is the index.html, perform an online-first request.
  if (key == '/') {
    return onlineFirst(event);
  }
  event.respondWith(caches.open(CACHE_NAME)
    .then((cache) =>  {
      return cache.match(event.request).then((response) => {
        // Either respond with the cached resource, or perform a fetch and
        // lazily populate the cache only if the resource was successfully fetched.
        return response || fetch(event.request).then((response) => {
          if (response && Boolean(response.ok)) {
            cache.put(event.request, response.clone());
          }
          return response;
        });
      })
    })
  );
});

self.addEventListener('message', (event) => {
  // SkipWaiting can be used to immediately activate a waiting service worker.
  // This will also require a page refresh triggered by the main worker.
  if (event.data === 'skipWaiting') {
    self.skipWaiting();
    return;
  }
  if (event.data === 'downloadOffline') {
    downloadOffline();
    return;
  }
});

// Download offline will check the RESOURCES for all files not in the cache
// and populate them.
async function downloadOffline() {
  var resources = [];
  var contentCache = await caches.open(CACHE_NAME);
  var currentContent = {};
  for (var request of await contentCache.keys()) {
    var key = request.url.substring(origin.length + 1);
    if (key == "") {
      key = "/";
    }
    currentContent[key] = true;
  }
  for (var resourceKey of Object.keys(RESOURCES)) {
    if (!currentContent[resourceKey]) {
      resources.push(resourceKey);
    }
  }
  return contentCache.addAll(resources);
}

// Attempt to download the resource online before falling back to
// the offline cache.
function onlineFirst(event) {
  return event.respondWith(
    fetch(event.request).then((response) => {
      return caches.open(CACHE_NAME).then((cache) => {
        cache.put(event.request, response.clone());
        return response;
      });
    }).catch((error) => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match(event.request).then((response) => {
          if (response != null) {
            return response;
          }
          throw error;
        });
      });
    })
  );
}
