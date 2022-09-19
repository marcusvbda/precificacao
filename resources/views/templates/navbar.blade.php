@php
$user = Auth::user();

function currentClass($routes)
{
$routes = is_array($routes) ? $routes : [$routes];
$class = '';
$current = Request::server('REQUEST_URI');
foreach ($routes as $route) {
$contain = strpos($route, '/*');
if (!$contain) {
if ($current == $route) {
return 'active';
}
} else {
$route = str_replace('/*', '', $route);
if (strpos($current, $route) !== false) {
return 'active';
}
}
}
return '';
}

$is_super_admin = $user->isSuperAdmin();
$is_admin = $user->hasRole(['admin']);
$is_admin_or_super_admin = $user->hasRole(['admin', 'super-admin']);

function getMenuClass($permission, $array_current = [])
{
$class = 'dropdown-item ' . currentClass($array_current);
$permission_value = is_bool($permission) ? $permission : hasPermissionTo($permission);
if (!$permission_value) {
$class .= ' disabled ';
}
return $class;
}

$wiki_url = '/admin/wiki';
if(!$is_super_admin) {
$wiki_url = '/admin/wiki/?order_by=id&order_type=asc';
}
$whatsapp_module = getEnabledModuleToUser("whatsapp");
$email_integrator = getEnabledModuleToUser("email-integrator");

@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light py-0">
    <a class="navbar-brand py-0" href="/admin">
        <text-logo size="30" app_name="{{ config('app.name') }}" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ currentClass(['/admin']) }}">
                <a class="nav-link" href="/"><i class="el-icon-s-home mr-2"></i>Página Inicial<span
                        class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown hover-color ml-0">
                <a class="nav-link dropdown-toggle py-0 d-flex flex-row align-items-center" href="#" id="navbarDropdown"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="d-flex flex-column mr-2">
                        <b>{{ $user->name }}</b>
                        <small class="f-12">{{ $user->email }}</small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/admin/usuarios/{{ $user->code }}/edit">
                        <div class="d-flex justify-content-between">
                            <span>Conta</span>
                            <span class="badge badge-default ml-5 pt-1 px-2">ID.: {{ $user->code }}</span>
                        </div>
                    </a>
                    <a class="dropdown-item {{ getMenuClass('viewlist-users',['/admin/usuarios/*'])  }}"
                        href="/admin/usuarios">Usuários</a>
                    @if ($is_admin_or_super_admin)
                    <a class="dropdown-item" href="/admin/modulos">Modulos</a>
                    @if($is_super_admin)
                    <a class="dropdown-item" href="/admin/log-viewer">Log Viewer</a>
                    @endif
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/login">Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>