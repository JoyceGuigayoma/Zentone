<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
$timeout_duration = 30;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();     
    session_destroy();  
    header("Location: index.php?timeout=true"); 
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Zentone - Sign Up</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <style>
    :root {
      --purple-light: #c49ef7;
      --purple-dark: #15082a;
      --pink-gradient-start: #8a2eff;
      --pink-gradient-end: #ea22ff;
      --form-bg: #0c0423;
      --text-light: #ddd1ff;
      --text-placeholder: #504d5e;
      --input-bg: #1e153f;
      --input-radius: 24px;
      --font-family: 'Poppins', sans-serif;
    }
    * {
      box-sizing: border-box;
    }
    body, html {
      margin: 0;
      min-height: 100vh;
      font-family: var(--font-family);
      background: url("images/bg.png");
      color: var(--text-light);
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    body::before {
      content: "";
      position: fixed;
      width: 140%;
      height: 110%;
      top: -10%;
      left: -20%;
      background:
        repeating-linear-gradient(
          45deg,
          rgba(167, 130, 229, 0.25),
          rgba(167, 130, 229, 0.25) 40px,
          transparent 40px,
          transparent 80px
        ),
        url('https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/cdf81075-a53d-4e31-a665-236c9b317d58.png') center center/cover no-repeat;
      opacity: 0.12;
      z-index: 0;
      pointer-events: none;
    }
    header {
      position: sticky;
      top: 0;
      width: 100%;
      backdrop-filter: saturate(180%) blur(12px);
      background-color: rgba(21, 8, 42, 0.85);
      border-bottom: 1px solid rgba(234, 34, 255, 0.15);
      z-index: 10;
    }
    .header-container {
      max-width: 1440px;
      margin: 0 auto;
      padding: 0 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 64px;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--pink-gradient-start);
      font-weight: 700;
      font-size: 1.25rem;
      user-select: none;
      cursor: default;
    }
    .logo img {
      width: 70px;
      height: 32px;
      filter: invert(45%) sepia(70%) saturate(600%) hue-rotate(230deg) brightness(90%);
    }
    nav.desktop-nav {
      display: flex;
      gap: 32px;
      font-weight: 500;
      font-size: 0.9rem;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      align-items: center;
      user-select: none;
    }
    nav.desktop-nav a {
      color: var(--text-light);
      text-decoration: none;
      padding: 4px 0;
      transition: color 0.25s ease;
    }
    nav.desktop-nav a:hover,
    nav.desktop-nav a.active {
      color: var(--pink-gradient-end);
      border-bottom: 2px solid var(--pink-gradient-end);
    }
    nav.desktop-nav a.signup {
      color: var(--pink-gradient-end);
      font-weight: 700;
      border-bottom: 2px solid var(--pink-gradient-end);
    }
    button.mobile-menu-btn {
      background: none;
      border: none;
      color: var(--pink-gradient-end);
      cursor: pointer;
      display: none;
      font-size: 28px;
    }
    nav.mobile-nav {
      position: fixed;
      top: 64px;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(21,8,42,0.97);
      padding: 24px 40px;
      display: none;
      flex-direction: column;
      gap: 32px;
      text-align: center;
      font-weight: 600;
      font-size: 1.5rem;
      z-index: 100;
    }
    nav.mobile-nav a {
      color: var(--pink-gradient-end);
      text-decoration: none;
      user-select: none;
      transition: color 0.3s ease;
    }
    nav.mobile-nav a:hover {
      color: var(--text-light);
    }
    nav.mobile-nav.show {
      display: flex;
    }
    main {
      min-height: calc(100vh - 64px);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 24px;
      z-index: 1;
      position: relative;
    }
    .container {
      max-width: 1440px;
      margin: 0 auto;
      padding: 0 16px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 32px;
      align-items: center;
      justify-content: center;
    }

    nav {
      display: flex;
      gap: 20px;
      align-items: center;
    }
    main {
      display: grid;
      gap: 32px;
      grid-template-columns: 1fr;
      padding-bottom: 48px;
    }
    @media (min-width: 767px) {
      main {
        grid-template-columns: 1fr 1fr;
      }
    }
    @media (min-width: 1440px) {
      .container {
        padding: 0 48px;
      }
    }
    .card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 10px 20px rgba(37, 9, 49, 0.12);
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    #emotion-recognition {
      max-width: 380px;
      min-height: 420px;
      justify-content: space-between;
    }

    #camera-frame {
      width: 100%;
      aspect-ratio: 1 / 1;
      background: #f0f0f0;
      border: 3px solid #3f2f63;
      border-radius: 24px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #888;
      font-weight: 700;
      font-size: 1rem;
      user-select: none;
    }

    #camera-frame .material-icons {
      font-size: 72px;
      color: #bbb;
      position: absolute;
      top: 100px;     
      left: 125px;     
    }
    #camera-frame p {
      position: absolute;
      bottom: 16px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 0.9rem;
    }

    .buttons {
      width: 100%;
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    button {
      background: #3f2f63;
      border: none;
      color: white;
      font-weight: 600;
      font-size: 1rem;
      padding: 12px 20px;
      border-radius: 12px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 10px rgba(63, 47, 99, 0.3);
      transition: background-color 0.3s ease;
    }
    button:hover {
      background: #5a41a0;
    }
    button:disabled {
      background: #9b95b9;
      cursor: not-allowed;
      box-shadow: none;
    }
    #music-recommendation {
      max-width: 380px;
      min-height: 420px;
      padding: 16px 24px;
      box-sizing: border-box;
      justify-content: flex-start;
    }

    #music-player {
      width: 100%;
      background: #f3efe6;
      border-radius: 20px;
      padding: 24px;
      box-sizing: border-box;
      box-shadow: 0 4px 10px rgba(37, 9, 49, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 16px;
    }

    #album-cover {
      width: 100%;
      aspect-ratio: 1 / 1;
      border-radius: 16px;
      background: #ddd;
    }

    #track-controls {
      display: flex;
      gap: 16px;
      align-items: center;
      justify-content: center;
    }

    .material-icons.control-icon {
      font-size: 36px;
      cursor: pointer;
      color: #3f2f63;
      transition: color 0.3s ease;
    }
    .material-icons.control-icon:hover {
      color: #5a41a0;
    }

    #progress-container {
      width: 100%;
      margin-top: 8px;
    }
    #progress {
      width: 100%;
    }
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo" aria-label="Zentone logo with waveform icon">
        <img src="images/logo.png" alt="Zentone logo waveform icon in purple" />
        Zentone
      </div>
      <nav class="desktop-nav" role="navigation" aria-label="Primary navigation">
        <a href="#" class="signup">Home</a>
        <a href="session_history_view.php">Session History</a>
        <a href="#" >Settings</a>
        <a href="logout.php" >Logout</a>
      </nav>
      <button class="mobile-menu-btn" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
        <span class="material-icons">menu</span>
      </button>
    </div>
  </header>
</head>
<body>
  <div class="container" role="main">
    <main>
      <section class="card" id="emotion-recognition" role="region" aria-label="Emotion Recognition section">
        <h2 style="font-weight:700; margin-bottom:16px;">Emotion Recognition</h2>
        <div id="camera-frame" aria-live="polite" aria-atomic="true" aria-describedby="camera-status-desc">
          <div>
            <span class="material-icons" style="font-size: 64px; color: #bbb;">photo_camera_off</span>
            <p id="camera-status-desc" style="margin-top: 8px; font-size: 0.9rem;">Camera is currently unavailable.</p>
        </div>

        </div>
        <div class="buttons">
          <button id="start-voice" aria-label="Start voice input">
            <span class="material-icons">mic</span> Start Voice
          </button>
          <button id="start-camera" aria-label="Start camera input">
            <span class="material-icons">photo_camera</span> Start Camera
          </button>
        </div>
      </section>

      <section class="card" id="music-recommendation" role="region" aria-label="Music Recommendation section">
        <h2 style="font-weight:700; margin-bottom:16px;">Music Recommendation</h2>
        <div id="music-player" aria-live="polite">
          <img
            id="album-cover"
            src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c99266af-222b-4c5a-bf6b-7b1f50694ef0.png"
            alt="Album cover placeholder image"
          />
          <input type="range" id="progress" value="0" min="0" max="100" aria-label="Track progress slider" />
          <div id="track-controls">
            <span class="material-icons control-icon" id="shuffle" title="Shuffle">shuffle</span>
            <span class="material-icons control-icon" id="prev" title="Previous Track">skip_previous</span>
            <span class="material-icons control-icon" id="play-pause" title="Play">play_circle_filled</span>
            <span class="material-icons control-icon" id="next" title="Next Track">skip_next</span>
            <span class="material-icons control-icon" id="favorite" title="Favorite">favorite_border</span>
            <span class="material-icons control-icon" id="repeat" title="Repeat">repeat</span>
          </div>
        </div>
      </section>
    </main>
  </div>
  <script>
  const startCameraBtn = document.getElementById('start-camera');
  const startVoiceBtn = document.getElementById('start-voice');
  const playPauseBtn = document.getElementById('play-pause');
  const cameraFrame = document.getElementById('camera-frame');

  let stream = null;
  let videoElement = null;
  let isPlaying = false;
  let emotionInterval = null;
  const musicPlayer = document.createElement('audio');
  musicPlayer.controls = false;
  document.getElementById('music-player').appendChild(musicPlayer);

  const tracksByEmotion = {
    happy: {
      cover: 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/19a02c34-931e-47ae-a210-d2db54bfe5ef.png',
      src: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'
    },
    sad: {
      cover: 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/d17df3e8-a783-464c-9509-f7764beba915.png',
      src: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3'
    },
    neutral: {
      cover: 'https://www.soundhelix.com/images/placeholder.jpg',
      src: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3'
    },
    angry: {
      cover: 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/d0f4b8b3-86d9-45f9-8227-4c52db424b14.png',
      src: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3'
    }
  };
  function detectEmotion() {
    const emotions = ['happy', 'sad', 'neutral', 'angry'];
    return emotions[Math.floor(Math.random() * emotions.length)];
  }

  function updateMusicByEmotion(emotion) {
    const track = tracksByEmotion[emotion] || tracksByEmotion['neutral'];
    document.getElementById('album-cover').src = track.cover;
    musicPlayer.src = track.src;
    musicPlayer.play();
    isPlaying = true;
    playPauseBtn.textContent = 'pause_circle_filled';
  }

  function logEmotionToDatabase(emotion, source = 'manual') {
    if (isPlaying) {
      musicPlayer.pause();
      playPauseBtn.textContent = 'play_circle_filled';
      isPlaying = false;
    }
    if (stream) {
      stream.getTracks().forEach(track => track.stop());
      stream = null;
      cameraFrame.innerHTML = `
        <div>
          <span class="material-icons" style="font-size: 64px; color: #bbb;">photo_camera_off</span>
          <p id="camera-status-desc">Camera is currently unavailable.</p>
        </div>
      `;
    }
    if (emotionInterval) {
      clearInterval(emotionInterval);
      emotionInterval = null;
    }
    console.log("Voice or camera input stopped.");
    const data = {
      emotion: emotion,
      source: source,
      timestamp: new Date().toISOString()
    };

    console.log("Logging emotion:", data);
    fetch('log_emotions.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        alert(`Emotion "${emotion}" logged from ${source}.`);
      } else {
        console.warn('Error logging emotion:', result.error);
        alert('Failed to log emotion.');
      }
    })
    .catch(error => {
      console.error('Network error:', error);
      alert('Network error during logging.');
    });
  }
  startCameraBtn.addEventListener('click', async () => {
    if (!stream) {
      try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        cameraFrame.innerHTML = '';
        videoElement = document.createElement('video');
        videoElement.autoplay = true;
        videoElement.playsInline = true;
        videoElement.srcObject = stream;
        videoElement.style.borderRadius = '24px';
        cameraFrame.appendChild(videoElement);

        emotionInterval = setInterval(() => {
          const emotion = detectEmotion();
          updateMusicByEmotion(emotion);
          logEmotionToDatabase(emotion, 'camera');
        }, 5000);
      } catch (err) {
        cameraFrame.innerHTML = '<p>Unable to access camera.</p>';
        console.error('Camera error:', err);
      }
    }
  });
  startVoiceBtn.addEventListener('click', () => {
    const emotion = detectEmotion();
    updateMusicByEmotion(emotion);
    alert(`Detected emotion from voice input: ${emotion}`);
    logEmotionToDatabase(emotion, 'voice');
  });
  playPauseBtn.addEventListener('click', () => {
    if (isPlaying) {
      musicPlayer.pause();
      playPauseBtn.textContent = 'play_circle_filled';
    } else {
      musicPlayer.play();
      playPauseBtn.textContent = 'pause_circle_filled';
    }
    isPlaying = !isPlaying;
  });
</script>
</body>
</html>