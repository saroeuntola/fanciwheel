<?php
include('./admin/page/library/auth.php');
$userAuth = new Auth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sex = $_POST['sex'];
    
    // Decode Base64 role_id
    $role_id_encoded = $_POST['role_id'];
    $role_id = base64_decode($role_id_encoded);

    if ($userAuth->register($username, $email, $password, $sex, $role_id)) {
        echo "<div class='success-message'><p>Registration successful!</p></div>";
        header("Location: login.php");
        exit;
    } else {
        echo "<div class='error-message'><p>Error occurred during registration.</p></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Join Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    * { font-family: 'Inter', sans-serif; }
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      position: relative;
      overflow: hidden;
    }
    .gradient-bg::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7, #dda0dd);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      opacity: 0.1;
    }
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .input-field {
      width: 100%;
      padding: 1rem 1.25rem;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      color: white;
      font-size: 1rem;
      backdrop-filter: blur(10px);
    }
    .input-field:focus {
      outline: none;
      border-color: #60a5fa;
      background: rgba(255, 255, 255, 0.15);
    }
    .input-field::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }
    .radio-group {
      display: flex;
      gap: 1.5rem;
      margin-top: 0.5rem;
    }
    .radio-option {
      display: flex;
      align-items: center;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      flex: 1;
      justify-content: center;
    }
    .radio-option input[type="radio"] {
      appearance: none;
      width: 1.25rem;
      height: 1.25rem;
      border: 2px solid rgba(255, 255, 255, 0.4);
      border-radius: 50%;
      background: transparent;
      margin-right: 0.75rem;
      position: relative;
    }
    .radio-option input[type="radio"]:checked {
      border-color: #60a5fa;
      background: rgba(96, 165, 250, 0.2);
    }
    .radio-option input[type="radio"]:checked::after {
      content: '';
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      width: 0.5rem;
      height: 0.5rem;
      border-radius: 50%;
      background: #60a5fa;
    }
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 1rem 2rem;
      border-radius: 12px;
      color: white;
      font-weight: 600;
      font-size: 1.1rem;
      width: 100%;
      transition: all 0.3s ease;
    }
    .success-message, .error-message {
      margin-top: 1rem;
      padding: 1rem;
      border-radius: 12px;
      backdrop-filter: blur(10px);
    }
    .success-message {
      background: rgba(34, 197, 94, 0.1);
      border: 1px solid rgba(34, 197, 94, 0.3);
      color: #86efac;
    }
    .error-message {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #fca5a5;
    }
    .title-text {
      font-size: 2.5rem;
      font-weight: 700;
      color: white;
    }
    .subtitle-text {
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 2rem;
    }
  </style>
</head>
<body class="gradient-bg">
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-lg">
      <div class="glass-card p-8 rounded-2xl">
        <div class="text-center mb-8">
          <h1 class="title-text">Join Us</h1>
          <p class="subtitle-text">Create your account to get started</p>
        </div>

        <form action="register.php" method="POST" id="registerForm">
          <div class="mb-4">
            <input type="text" name="username" placeholder="Username" required class="input-field" />
          </div>
          <div class="mb-4">
            <input type="email" name="email" placeholder="Email" required class="input-field" />
          </div>
          <div class="mb-4">
            <input type="password" name="password" id="password" placeholder="Password" required class="input-field" />
          </div>
          <div class="mb-4">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required class="input-field" />
          </div>
          <div class="mb-6">
            <label class="block text-white mb-2">Gender</label>
            <div class="radio-group">
              <div class="radio-option">
                <input type="radio" name="sex" id="male" value="male" required />
                <label for="male" class="text-white">Male</label>
              </div>
              <div class="radio-option">
                <input type="radio" name="sex" id="female" value="female" required />
                <label for="female" class="text-white">Female</label>
              </div>
            </div>
          </div>

          <input type="hidden" name="role_id" id="role_id" value="">

          <button type="submit" class="btn-primary">Create Account</button>

          <div class="text-center mt-4">
            <a href="login.php" class="text-white underline hover:text-blue-300">Already have an account? Sign in</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>

    document.getElementById('registerForm').addEventListener('submit', function (e) {
      const password = document.getElementById('password').value;
      const confirm = document.getElementById('confirm_password').value;

      if (password !== confirm) {
        e.preventDefault();
        alert('Passwords do not match!');
        return;
      }

      // Encode role_id and set value
      const encoded = btoa('2'); // "Mg=="
      document.getElementById('role_id').value = encoded;
    });
  </script>
</body>
</html>
