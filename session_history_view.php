<?php
session_start();

$timeout_duration = 300;

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Emotion History</title>
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
    h1 {
      text-align: center;
      color: #4B0082;
      margin-top: 40px;
    }

    button.view-history-btn {
      width: 100%;
      border: none;
      border-radius: 24px;
      padding: 14px 0;
      font-size: 1rem;
      font-weight: 600;
      color: white;
      cursor: pointer;
      background-image: linear-gradient(90deg, var(--pink-gradient-start), var(--pink-gradient-end));
      box-shadow: 0 8px 24px rgba(234, 34, 255, 0.75);
      transition: box-shadow 0.3s ease, transform 0.3s ease;
      user-select: none;
    }
    button.view-history-btn:hover {
      box-shadow: 0 12px 36px rgba(234, 34, 255, 0.9);
      transform: translateY(-4px);
    }
    ul#emotion-history {
      list-style: none;
      padding: 0 20px;
      margin-top: 20px;
    }
    ul#emotion-history li {
      background: #fff;
      color: #000;
      padding: 10px;
      border-radius: 12px;
      margin-bottom: 8px;
    }
    .consent-container {
      text-align: center;
      margin: 20px auto;
    }
    .consent-container label {
      font-size: 1rem;
      color: var(--text-light);
    }
    .consent-container input[type="checkbox"] {
      transform: scale(1.2);
      margin-right: 10px;
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
        <a href="dashboard.php">Home</a>
        <a href="session_history_view.php" class="signup">Session History</a>
        <a href="#" >Settings</a>
        <a href="logout.php" >Logout</a>
      </nav>
      <button class="mobile-menu-btn" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
        <span class="material-icons">menu</span>
      </button>
    </div>
  </header>
  <h1>Session Emotion History</h1>
  <div class="consent-container">
    <label>
      <input type="checkbox" id="consent-checkbox">
      I consent to share my emotional data with third-party services.
    </label>
  </div>
  <button class="view-history-btn" id="view-history-btn">View Emotion History</button>
  <ul id="emotion-history"></ul>

  <script>
    document.getElementById('view-history-btn').addEventListener('click', () => {
      fetch('get_emotion_history.php')
        .then(response => response.json())
        .then(logs => {
          const list = document.getElementById('emotion-history');
          list.innerHTML = '';
          if (logs.error) {
            const li = document.createElement('li');
            li.textContent = logs.error;
            list.appendChild(li);
          } else if (logs.length === 0) {
            const li = document.createElement('li');
            li.textContent = 'No emotion logs yet.';
            list.appendChild(li);
          } else {
            logs.forEach(log => {
              const li = document.createElement('li');
              li.textContent = `${log.timestamp} — ${log.source} — ${log.emotion}`;
              list.appendChild(li);
            });
          }
        })
        .catch(err => {
          console.error('Error:', err);
        });
    });
    document.getElementById('consent-checkbox').addEventListener('change', function () {
      const consentStatus = this.checked ? 1 : 0;

      fetch('update_consent.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ consent: consentStatus })
      })
      .then(response => response.json())
      .then(data => {
        alert(data.success ? 'Consent updated successfully.' : 'Failed to update consent.');
      })
      .catch(err => {
        console.error('Error updating consent:', err);
      });
    });
  </script>
</body>
</html>
