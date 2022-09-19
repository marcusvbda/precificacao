@extends("templates.admin")
@section('title',"Dashboard")

@section('breadcrumb')
<div class="row">
	<div class="col-12">
		<nav aria-label="breadcrumb">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0">
					<li class="breadcrumb-item">
						<a href="/admin" class="link">Página Inicial</a>
					</li>
		 			<li class="breadcrumb-item active" aria-current="page">Dashboard</li>					
				</ol>
			</nav>
		</nav>
	</div>
</div>
@endsection
@section('content')
@php
    $user = Auth::user(); 
    $is_superadmin = $user->hasRole(["super-admin"]);
	$tenant = (@$_GET["tenant_id"] && $is_superadmin) ? \App\Http\Models\Tenant::findOrFail($_GET["tenant_id"]) : $user->tenant;
	$is_head = $user->polo->data->head
@endphp
<dashboard-content
	title="Mostradores e Desempenho"
	user_id="{{ $user->id }}"
	:is_head='@json($is_head)'
>
</dashboard-content>
@endsection
