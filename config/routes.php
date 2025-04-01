<?php 

	$routes = array(
		'/' => 'tasks#index',
		'/tasks' => 'tasks#index',
		'/tasks/' => 'tasks#index',
		'/tasks/view/id/:id' => 'tasks#view',
		'/tasks/create' => 'tasks#create',
		'/tasks/edit/id/:id' => 'tasks#edit',
		'/tasks/delete/id/:id' => 'tasks#delete',
		'/tasks/delete-confirm/id/:id' => 'tasks#delete'
	);