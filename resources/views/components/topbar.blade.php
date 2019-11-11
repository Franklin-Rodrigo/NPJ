<header class="d-none d-lg-block">
  <nav class="navbar navbar-expand navbar-light bg-light">
    <span class="navbar-text text-dark">
      Olá, <strong>{{$slot}}</strong> - Bem-vindo de volta
    </span>
    
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <button type="button" name="button" class="btn btn-sm btn-outline-danger" onClick="location.href='{{URL::to('Sair')}}'">
          <span class="fas fa-sign-out-alt"></span>
          SAIR
        </button>
      </li>
    </ul>
  </nav>

</header>