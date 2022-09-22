<?php

return [
    "super-admin" => [
        "title" => "Super Admin",
        "permissions" => "all",
        "hidden" => true
    ],
    "user" => [
        "title" => "Usuário",
        "permissions" => [
            ["viewlist-products", "Ver Lista de Produtos"],
            ["create-products", "Criar Produtos"],
            ["edit-products", "Editar Produtos"],
            ["destroy-products", "Excluir Produtos"],

            ["viewlist-marketplaces", "Ver Lista de Marketplaces"],
            ["create-marketplaces", "Criar Marketplaces"],
            ["edit-marketplaces", "Editar Marketplaces"],
            ["destroy-marketplaces", "Excluir Marketplaces"],

            ["viewlist-expenses", "Ver Lista de Despesas"],
            ["create-expenses", "Criar Despesas"],
            ["edit-expenses", "Editar Despesas"],
            ["destroy-expenses", "Excluir Despesas"],
        ]
    ],
    "admin" => [
        "title" => "Admin",
        "permissions" => [
            ["viewlist-products", "Ver Lista de Produtos"],
            ["create-products", "Criar Produtos"],
            ["edit-products", "Editar Produtos"],
            ["destroy-products", "Excluir Produtos"],

            ["viewlist-marketplaces", "Ver Lista de Marketplaces"],
            ["create-marketplaces", "Criar Marketplaces"],
            ["edit-marketplaces", "Editar Marketplaces"],
            ["destroy-marketplaces", "Excluir Marketplaces"],

            ["viewlist-expenses", "Ver Lista de Despesas"],
            ["create-expenses", "Criar Despesas"],
            ["edit-expenses", "Editar Despesas"],
            ["destroy-expenses", "Excluir Despesas"],
        ]
    ]
];
