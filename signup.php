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
    .form-wrapper {
      background: var(--form-bg);
      border-radius: 16px;
      padding: 48px 40px 56px;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 12px 28px rgba(234, 34, 255, 0.3);
      user-select: none;
      text-align: center;
    }
    .form-wrapper h1 {
      color: var(--pink-gradient-start);
      font-weight: 500;
      font-size: 1.9rem;
      margin-bottom: 32px;
      user-select: text;
    }

    form {
      display: grid;
      row-gap: 20px;
      text-align: left;
    }
    .input-group-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
    }
    label {
      display: block;
      font-size: 0.8rem;
      color: var(--purple-light);
      margin-bottom: 6px;
      user-select: text;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      background-color: var(--input-bg);
      border: none;
      border-radius: var(--input-radius);
      color: var(--text-light);
      padding: 14px 20px;
      font-size: 1rem;
      font-weight: 500;
      outline-offset: 4px;
      outline-color: var(--pink-gradient-end);
      transition: outline-color 0.3s ease;
      font-family: var(--font-family);
    }
    input[type="text"]::placeholder,
    input[type="email"]::placeholder,
    input[type="password"]::placeholder {
      color: var(--text-placeholder);
      font-style: italic;
      font-weight: 400;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      outline-color: var(--pink-gradient-start);
    }
    .password-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .password-wrapper input {
      padding-right: 44px;
      flex-grow: 1;
    }
    .password-wrapper .material-icons {
      position: absolute;
      right: 16px;
      cursor: pointer;
      user-select: none;
      color: var(--purple-light);
      font-size: 20px;
      transition: color 0.25s ease;
    }
    .password-wrapper .material-icons:hover {
      color: var(--pink-gradient-end);
    }
    button.submit-btn {
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
    button.submit-btn:hover {
      box-shadow: 0 12px 36px rgba(234, 34, 255, 0.9);
      transform: translateY(-4px);
    }
    .login-text {
      user-select: text;
      margin-top: 12px;
      font-size: 0.85rem;
      color: var(--purple-light);
      text-align: center;
    }
    .login-text a {
      color: var(--pink-gradient-end);
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      transition: color 0.25s ease;
    }
    .login-text a:hover {
      text-decoration: underline;
      color: var(--pink-gradient-start);
    }
    @media (max-width: 767px) {
      .header-container {
        padding: 0 16px;
      }
      nav.desktop-nav {
        display: none;
      }
      button.mobile-menu-btn {
        display: block;
      }
      nav.mobile-nav {
        padding: 48px 24px;
        font-weight: 500;
        font-size: 1.25rem;
      }
      .form-wrapper {
        padding: 36px 24px 48px;
        margin: 48px 16px;
        max-width: 100%;
      }
      form .input-group-row {
        display: block;
      }
    }
    @media (min-width: 768px) and (max-width: 1439px) {
      main {
        padding: 48px 24px;
      }
    }
    @media (min-width: 1440px) {
      .header-container {
        max-width: 1320px;
        margin: 0 auto;
      }
      main {
        padding: 64px 32px;
      }
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
        <a href="#" aria-current="page">Home</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <a href="#" class="signup">Sign Up</a>
      </nav>
      <button class="mobile-menu-btn" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
        <span class="material-icons">menu</span>
      </button>
    </div>
    <nav class="mobile-nav" id="mobile-menu" role="navigation" aria-label="Mobile primary navigation" aria-hidden="true">
      <a href="#">Home</a>
      <a href="#">About Us</a>
      <a href="#">Contact</a>
      <a href="#" class="signup">Sign Up</a>
    </nav>
  </header>
  <main>
    <section class="form-wrapper" aria-label="Sign up form">
      <h1>Sign up</h1>
      <form action="db.php" method="POST" id="signUpForm" novalidate>
        <div>
          <label for="fullName">Full Name</label>
          <input
            type="text"
            id="fullName"
            name="name"
            placeholder="Enter your Full Name"
            autocomplete="name"
            required
            aria-required="true"
            aria-describedby="fullName-desc"
          />
        </div>
        <div>
          <label for="email">Email Address</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="email@zentone.com"
            autocomplete="email"
            required
            aria-required="true"
            aria-describedby="email-desc"
          />
        </div>
        <div class="input-group-row">
          <div>
            <label for="password">Password</label>
            <div class="password-wrapper">
              <input
                type="password"
                id="password"
                name="password"
                placeholder="**********"
                autocomplete="new-password"
                required
                aria-required="true"
                aria-describedby="password-desc"
              />
              <span class="material-icons" tabindex="0" role="button" aria-label="Toggle password visibility" aria-pressed="false" id="togglePassword1">visibility_off</span>
            </div>
          </div>
          <div>
            <label for="confirmPassword">Confirm Password</label>
            <div class="password-wrapper">
              <input
                type="password"
                id="confirmPassword"
                name="confirmPassword"
                placeholder="**********"
                autocomplete="new-password"
                required
                aria-required="true"
                aria-describedby="confirmPassword-desc"
              />
              <span class="material-icons" tabindex="0" role="button" aria-label="Toggle confirm password visibility" aria-pressed="false" id="togglePassword2">visibility_off</span>
            </div>
          </div>
        </div>
        <button type="submit" name="signup" class="submit-btn">Create Account</button>
      </form>
      <p class="login-text">or <a href="index.php">Log in</a></p>
    </section>
  </main>

 <script>
  function togglePasswordVisibility(toggleId, inputId) {
    const toggle = document.getElementById(toggleId);
    const input = document.getElementById(inputId);

    toggle.addEventListener('click', () => {
      const visible = input.type === 'text';
      input.type = visible ? 'password' : 'text';
      toggle.textContent = visible ? 'visibility_off' : 'visibility';
      toggle.setAttribute('aria-pressed', String(!visible));
    });

    toggle.addEventListener('keydown', (event) => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        toggle.click();
      }
    });
  }

  togglePasswordVisibility('togglePassword1', 'password');
  togglePasswordVisibility('togglePassword2', 'confirmPassword');

  const form = document.getElementById('signUpForm');
  form.addEventListener('submit', (e) => {
    if (!form.checkValidity()) {
      e.preventDefault();
      form.reportValidity();
      return;
    }

    const password = form.password.value;
    const confirmPassword = form.confirmPassword.value;
    if (password !== confirmPassword) {
      e.preventDefault();
      alert("Passwords do not match.");
    }
  });
</script>

</body>
</html>

