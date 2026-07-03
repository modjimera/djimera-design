const CACHE_NAME = 'djimera-design-manager-v3';
const APP_SHELL = [
    '/offline.html',
    '/manifest.webmanifest',
    '/images/djimera-logo.png',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/icons/maskable-512x512.png'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(APP_SHELL))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(keys => Promise.all(keys.map(key => key !== CACHE_NAME ? caches.delete(key) : null)))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    if (url.pathname.startsWith('/build/') || url.pathname.startsWith('/css/') || url.pathname.startsWith('/js/')) {
        event.respondWith(
            fetch(request)
                .then(response => {
                    const copy = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(request, copy));
                    return response;
                })
                .catch(() => caches.match(request))
        );
        return;
    }

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then(response => {
                    const copy = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(request, copy));
                    return response;
                })
                .catch(() => caches.match(request).then(cached => cached || caches.match('/offline.html')))
        );
        return;
    }

    event.respondWith(
        caches.match(request)
            .then(cached => cached || fetch(request).then(response => {
                if (!response || response.status !== 200 || response.type === 'opaque') {
                    return response;
                }

                const copy = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(request, copy));
                return response;
            }))
            .catch(() => caches.match('/offline.html'))
    );
});
