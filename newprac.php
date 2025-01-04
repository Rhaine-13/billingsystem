<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing System</title>
</head>
<body>
    <button id="startRecognition">Start Voice Recognition</button>
    <p id="voiceOutput"></p>
<script>
    if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.onresult = function(event) {
            document.getElementById('voiceOutput').innerText = event.results[0][0].transcript;
        };

        document.getElementById('startRecognition').addEventListener('click', function() {
            recognition.start();
        });
    } else {
        alert('Speech Recognition API is not supported in this browser.');
    }
</script>
</body>
</html>