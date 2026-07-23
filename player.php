<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Live Stream</title>

    <style>
        html,
        body {
            margin: 0;
            min-height: 100%;
            background: #111;
        }

        .player-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        video {
            display: block;
            width: 100%;
            max-width: 1280px;
            max-height: 100vh;
            background: #000;
        }

        #error {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            left: 1rem;
            display: none;
            padding: 1rem;
            color: #fff;
            background: rgba(160, 0, 0, 0.9);
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <main class="player-container">
        <video
            id="player"
            controls
            playsinline
            preload="auto"
        ></video>
    </main>

    <div id="error"></div>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@1/dist/hls.min.js"></script>

    <script>
        const streamUrl = 'osh.php?d=<?php echo $_GET['d']; ?>';

        const video = document.getElementById('player');
        const errorElement = document.getElementById('error');

        let hls = null;

        function showError(message) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        function initialisePlayer() {
            /*
             * Prefer HLS.js where MediaSource is available.
             */
            if (window.Hls && Hls.isSupported()) {
                hls = new Hls({
                    enableWorker: true,
                    lowLatencyMode: true,
                    backBufferLength: 90,
                    maxLiveSyncPlaybackRate: 1.05
                });

                hls.loadSource(streamUrl);
                hls.attachMedia(video);

                hls.on(Hls.Events.MANIFEST_PARSED, () => {
                    console.log('Combined HLS stream loaded');
                });

                hls.on(Hls.Events.AUDIO_TRACK_SWITCHED, (_, data) => {
                    console.log('Audio track selected:', data.id);
                });

                hls.on(Hls.Events.ERROR, (_, data) => {
                    console.error('HLS error:', data);

                    if (!data.fatal) {
                        return;
                    }

                    switch (data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            console.warn('Attempting network recovery');
                            hls.startLoad();
                            break;

                        case Hls.ErrorTypes.MEDIA_ERROR:
                            console.warn('Attempting media recovery');
                            hls.recoverMediaError();
                            break;

                        default:
                            showError(
                                'The stream could not be played. Please reload the page.'
                            );

                            hls.destroy();
                            break;
                    }
                });

                return;
            }

            /*
             * Safari and other browsers with native HLS support.
             */
            if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = streamUrl;

                video.addEventListener('error', () => {
                    showError(
                        'The stream could not be played by this browser.'
                    );
                });

                return;
            }

            showError('This browser does not support HLS playback.');
        }

        initialisePlayer();

        window.addEventListener('beforeunload', () => {
            if (hls) {
                hls.destroy();
            }
        });
    </script>
</body>
</html>