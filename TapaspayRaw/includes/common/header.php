<header class="bg-dark text-white">
    <?php
    
    $uri_with_project_name = $_SERVER['REQUEST_URI'];
    $project_name = 'cartas';
    $uri = preg_replace("/^(\/$project_name\/)/", '/', $uri_with_project_name);
    
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="/cartas">Cartas y Menus</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if ($uri === '/') echo 'active';?>" href="/cartas">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($uri === '/cartas') echo 'active';?>" href="/cartas/cartas">Cartas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($uri === '/menus') echo 'active';?>" href="/cartas/menus">Menu</a>
                </li>
            </ul>
        </div>

    </nav>
</header>