Source streams: https://www.eaa.org/airventure/live
Live videos from Oshkosh AirVenture 2026 air show

Pop file on php ready server, with allow_url_fopen setting enabled.
Throw url with ?d=1 parameters into vlc player or similar that can play m3u8 files
Enjoy!

Note -to make your own full video of the streams, use ffmpeg - ie:
"C:\Program Files (x86)\WinFF\ffmpeg.exe" -i "https://stream.webmad.co.nz/osh/osh.php?d=2" -c copy -bsf:a aac_adtstoasc "osh2026-day2.mp4"

Note - all content is owned by EAA streamed via Brightcove - this code expresses no ownership transfer, it is purely a tool to enable playback outside of Brightcove's player
We'll try to update this for each day's featured stream at timings that work. Note - we're in New Zealand, so timeframes flexible, but contribute as you like to keep this up to date.

Cheers!