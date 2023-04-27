  <?php
function GetNav($input) {
echo"
  <nav class='navbar navbar-dark bg-dark fixed-top'>
  <div class='container-fluid'>
    <a class='navbar-brand' href='index.php'>ItsTastY $input</a>
    <button class='navbar-toggler' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasDarkNavbar' aria-controls='offcanvasDarkNavbar' aria-label='Toggle navigation'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='offcanvas offcanvas-end text-bg-dark' tabindex='-1' id='offcanvasDarkNavbar' aria-labelledby='offcanvasDarkNavbarLabel'>
      <div class='offcanvas-header'>
        <h5 class='offcanvas-title' id='offcanvasDarkNavbarLabel'>Menü</h5>
        <button type='button' class='btn-close btn-close-white' data-bs-dismiss='offcanvas' aria-label='Close'></button>
      </div>
      <div class='offcanvas-body'>
        <ul class='navbar-nav justify-content-end flex-grow-1 pe-3'>
          <li class='nav-item'>
            <a class='nav-link active' aria-current='page' href='index.php'>Home</a>
            <a class='nav-link active' aria-current='page' href='login.php'>Anmelden</a>
            <a class='nav-link active' aria-current='page' href='registration.php'>Registrieren</a>
          </li>
          <!--<li class='nav-item'>
            <a class='nav-link' href='#'>Link</a>
          </li>-->
          <!--<li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
              Dropdown
            </a>
            <ul class='dropdown-menu dropdown-menu-dark'>
              <li><a class='dropdown-item' href='login.php'>Anmelden</a></li>
              <li><a class='dropdown-item' href='registration.php'>Registrieren</a></li>
              <li>
                <hr class='dropdown-divider'>
              </li>
              <li><a class='dropdown-item' href='#'>Something else here</a></li>
            </ul>
          </li>-->
        </ul>
        <form class='d-flex mt-3' role='search'>
          <input class='form-control me-2' type='search' placeholder='Search' aria-label='Search'>
          <button class='btn btn-success' type='submit'>Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>";
}

function GetFooter() {
  echo"
<footer class='bg-dark py-4 mt-5'>
  <div class='container text-light text-center'>
    <p class='display-5 mb-3'>© ItsTastY-Team.</p>
    <small class='text-white-50'>© ItsTastY-Team.</small>
  </div>
</footer>";
}
?>