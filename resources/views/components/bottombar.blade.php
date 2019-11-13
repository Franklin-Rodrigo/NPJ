<section class="d-lg-none d-block">
  <nav class="navbar navbar-expand fixed-bottom navbar-light bg-light">
    
    <ul class="navbar-nav mx-auto">
      @if($slot == "admin")
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Alunos')}}" class="nav-link text-center">
          <span class="fas fa-user fa-lg"></span>
          <small>Alunos</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Duplas')}}" class="nav-link text-center">
          <span class="fas fa-user-friends fa-lg"></span>
          <small>Duplas</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Professores')}}" class="nav-link text-center">
          <span class="fas fa-user-graduate fa-lg"></span>
          <small>Professores</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Grupos')}}" class="nav-link">
          <span class="fas fa-users fa-lg"></span>
          <small>Grupos</small>
        </a>
      </li>
      <li class="nav-item ">
        <a href="{{URL::to('Admin/Defensores')}}" class="nav-link text-center">
          <span class="fas fa-user-tie fa-lg"></span>
          <small>Defensores</small>
        </a>
      </li>
      @elseif($slot == "student")
       <li class="nav-item ml-auto">
          <a href="{{URL::to('Aluno/')}}" class="nav-link text-center">
            <span class="fas fa-home fa-lg"></span>
            <small>home</small>
        </a>
        </li>
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Aluno/Peticoes')}}" class="nav-link text-center">
            <span class="fas fa-user-tie fa-lg"></span>
            <small>Petições</small>
        </a>
        </li>
      @elseif($slot == "teacher")
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Professor/')}}" class="nav-link text-center">
            <span class="fas fa-home fa-lg"></span>
            <small>home</small>
        </a>
        </li>
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Professor/Duplas')}}" class="nav-link text-center">
            <span class="fas fa-user-friends fa-lg"></span>
            <small>Duplas</small>
        </a>
        </li>
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Professor/Peticoes')}}" class="nav-link text-center">
            <span class="fas fa-file-alt fa-lg"></span>
            <small>Petições</small>
        </a>
        </li>
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Professor/Templates')}}" class="nav-link text-center">
            <span class="fas fa-file fa-lg"></span>
            <small>Templates</small>
        </a>
        </li>
        @elseif($slot == "supervisor")
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Supervisor/')}}" class="nav-link text-center">
            <span class="fas fa-home fa-lg"></span>
            <small>home</small>
        </a>
        </li>
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Supervisor/Peticoes')}}" class="nav-link text-center">
            <span class="fas fa-file-alt fa-lg"></span>
            <small>Petições</small>
        </a>
        </li>
        @elseif($slot == "defender")
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Defensor/')}}" class="nav-link text-center">
            <span class="fas fa-home fa-lg"></span>
            <small>home</small>
        </a>
        </li>
        <li class="nav-item ml-auto">
          <a href="{{URL::to('Defensor/Peticoes')}}" class="nav-link text-center">
            <span class="fas fa-file-alt fa-lg"></span>
            <small>Petições</small>
        </a>
        </li>

      @endif
     
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="{{URL::to('Sair')}}" class="text-danger" onClick="location.href='{{URL::to('Sair')}}'">          
          <span class="fas fa-sign-out-alt fa-lg"></span>
          <small>Sair</small>
        </a>
      </li>
    </ul>
  </nav>

</section>