<?php
// Start the session
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT owner_id FROM owner WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["owner_id"] = $row["owner_id"]; // Set owner_id in session
        header("Location: tenant_dashboard.php");
        exit();
    } else {
        $errorMessage = "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /*=============== GOOGLE FONTS ===============*/
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

/*=============== VARIABLES CSS ===============*/
:root {
  /*========== Colors ==========*/
  /*Color mode HSL(hue, saturation, lightness)*/
  --first-color: hsl(122, 75%, 57%);
  --second-color: hsl(127, 64%, 47%);
  --title-color: hsl(122, 12%, 12%);
  --text-color: hsl(122, 4%, 36%);
  --body-color: hsl(128, 97%, 85%);


  /*========== Font and typography ==========*/
  /*.5rem = 8px | 1rem = 16px ...*/
  --body-font: "Poppins", sans-serif;
  --h2-font-size: 1.25rem;
  --small-font-size: .813rem;
  --smaller-font-size: .75rem;

  /*========== Font weight ==========*/
  --font-medium: 500;
  --font-semi-bold: 600;
}

/* Responsive typography */
@media screen and (min-width: 1024px) {
  :root {
    --h2-font-size: 1.75rem;
    --normal-font-size: 1rem;
    --small-font-size: .875rem;
    --smaller-font-size: .813rem;
  }
}

/*=============== BASE ===============*/
* {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
}

body {
  background-color: var(--body-color);
  font-family: var(--body-font);
  color: var(--text-color);
}

input,
button {
  font-family: var(--body-font);
  border: none;
  outline: none;
}

button {
  cursor: pointer;
}

img {
  max-width: 100%;
  height: auto;
}

/*=============== LOGIN FORM ===============*/
.login__content,
.login__form,
.login__inputs {
  display: grid;
}

.login__content {
  position: relative;
  height: 100vh;
  align-items: center;
}

.login__img {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.login__form {
  position: relative;
  background-color: hsla(244, 16%, 92%, 0.6);
  border: 2px solid hsla(244, 16%, 92%, 0.75);
  margin-inline: 1.5rem;
  row-gap: 1.25rem;
  backdrop-filter: blur(20px);
  padding: 2rem;
  border-radius: 1rem;
}

.login__title {
  color: var(--title-color);
  font-size: var(--h2-font-size);
  margin-bottom: 0.5rem;
}

.login__title span {
  color: var(--first-color);
}

.login__description {
  font-size: var(--small-font-size);
}

.login__inputs {
  row-gap: 0.75rem;
  margin-bottom: 0.5rem;
}

.login__label {
  display: block;
  color: var(--title-color);
  font-size: var(--small-font-size);
  font-weight: var(--font-semi-bold);
  margin-bottom: 0.25rem;
}

.login__input {
  width: 100%;
  padding: 14px 12px;
  border-radius: 6px;
  border: 2px solid var(--text-color);
  background-color: hsla(244, 16%, 92%, 0.6);
  color: var(--title-color);
  font-size: var(--smaller-font-size);
  font-weight: var(--font-medium);
  transition: border 0.4s;
}

.login__input::placeholder {
  color: var(--text-color);
}

.login__input:focus,
.login__input:valid {
  border: 2px solid var(--first-color);
}

.login__box {
  position: relative;
}

.login__box .login__input {
  padding-right: 36px;
}

.login__eye {
  width: max-content;
  height: max-content;
  position: absolute;
  right: 0.75rem;
  top: 0;
  bottom: 0;
  margin: auto 0;
  font-size: 1.25rem;
  cursor: pointer;
}

.login__check-label {
  position: relative;
  display: flex;
  column-gap: 0.5rem;
  align-items: center;
  cursor: pointer;
  font-size: var(--small-font-size);
}

.login__check-icon {
  position: absolute;
  display: none;
  font-size: 16px;
}

.login__check-input {
  appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid var(--text-color);
  background-color: hsla(244, 16%, 92%, 0.2);
  border-radius: 0.25rem;
  cursor: pointer;
}

.login__check-input:checked {
  background: var(--first-color);
}

.login__check-input:checked + .login__check-icon {
  display: block;
  color: #fff;
}

.login__buttons {
  display: flex;
  column-gap: 0.75rem;
}

.login__button {
  width: 100%;
  padding: 14px 2rem;
  border-radius: 6px;
  background: linear-gradient(180deg, var(--first-color), var(--second-color));
  color: #fff;
  font-size: var(--small-font-size);
  font-weight: var(--font-semi-bold);
  box-shadow: 0 6px 24px hsla(244, 75%, 48%, 0.5);
  margin-bottom: 1rem;
}

.login__button-ghost {
  background: hsla(244, 16%, 92%, 0.6);
  border: 2px solid var(--first-color);
  color: var(--first-color);
  box-shadow: none;
}

.login__forgot {
  font-size: var(--smaller-font-size);
  font-weight: var(--font-semi-bold);
  color: var(--first-color);
  text-decoration: none;
}

/*=============== BREAKPOINTS ===============*/
/* For small devices */
@media screen and (max-width: 360px) {
  .login__buttons {
    flex-direction: column;
  }
}

/* For medium devices */
@media screen and (min-width: 576px) {
  .login__form {
    width: 450px;
    justify-self: center;
  }
}

/* For large devices */
@media screen and (min-width: 1064px) {
  .container {
    height: 100vh;
    display: grid;
    place-items: center;
  }

  .login__content {
    width: 1024px;
    height: 600px;
  }

  .login__img {
    position: absolute;
    top: 50%;
    left: 30%;
    transform: translate(-50%, -50%);
    max-width: 250px; /* Adjust image size as needed */
    max-height: 150px; /* Adjust image size as needed */
    border-radius: 20%;
    box-shadow: 0 24px 48px hsla(244, 75%, 36%, 0.45);
}


  .login__form {
    justify-self: flex-end;
    margin-right: 4.5rem;
  }
}

@media screen and (min-width: 1200px) {
  .login__content {
    height: 700px;
  }

  .login__form {
    row-gap: 2rem;
    padding: 3rem;
    border-radius: 1.25rem;
    border: 2px solid hsla(244, 16%, 92%, 0.75);
  }

  .login__description,
  .login__label,
  .login__button {
    font-size: var(--normal-font-size);
  }

  .login__inputs {
    row-gap: 1.25rem;
    margin-bottom: 0.75rem;
  }

  .login__input {
    border: 2.5px solid var(--text-color);
    padding: 1rem;
    font-size: var(--small-font-size);
  }

  .login__input:focus,
  .login__input:valid {
    border: 2.5px solid var(--first-color);
  }

  .login__button {
    padding-block: 1rem;
    margin-bottom: 1.25rem;
  }

  .login__button-ghost {
    border: 2.5px solid var(--first-color);
  }
  .error-message {
    display: none; /* Initially hide the error message */
}

.error-message {
  color: #ff0000;
  font-size: 14px;
  margin-top: 5px;
}
}
</style>
</head>
<body>
    <div class="container">
        <div class="login">
            <div class="login__content">
                <img class="login__img" src="../images/logo_1_criwwp.png" alt="Login image" />

                <form id="loginForm" method="POST" class="login__form">
                    <div>
                        <h1 class="login__title">
                            <span>Welcome</span> Back
                        </h1>

                        <p class="login__description">
                            Welcome! Please login to continue.
                        </p>
                    </div>

                    <div class="login__inputs">
                        <div>
                            <label for="username" class="login__label">Username:</label>
                            <input class="login__input" type="text" id="username" name="username" required>
                        </div>

                        <div>
                            <label for="password" class="login__label">Password:</label>
                            <div class="login__box">
                                <input class="login__input" type="password" id="password" name="password" required>
                                <i class="ri-eye-off-line login__eye" id="input-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="login__button">Login</button>
                    </div>

                    <div id="errorContainer" class="login__error"><?php echo isset($errorMessage) ? $errorMessage : ''; ?></div>
                </form>
            </div>
        </div>
    </div>

    <!--=============== MAIN JS ===============-->
    <script>
        /*=============== SHOW HIDDEN - PASSWORD ===============*/
const showHiddenPassword = (inputPassword, inputIcon) => {
  const input = document.getElementById(inputPassword),
        iconEye = document.getElementById(inputIcon)

  iconEye.addEventListener('click', () => {
    // Change password to text
    if (input.type === 'password') {
      // Switch to text
      input.type = 'text'

      // Add icon
      iconEye.classList.add('ri-eye-line')

      // Remove icon
      iconEye.classList.remove('ri-eye-off-line')
    } else {
      // Change to password
      input.type = 'password'

      // Remove icon
      iconEye.classList.remove('ri-eye-line')

      // Add icon
      iconEye.classList.add('ri-eye-off-line')
    }
  })
}

showHiddenPassword('password', 'input-icon')
    </script>
</body>
</html>
