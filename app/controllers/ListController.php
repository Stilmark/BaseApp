<?php
namespace BaseApp\Controller;

final class ListController
{
    public function staticVars(): array
    {
        return [
            'userStatus' => ['active', 'inactive', 'deleted']
        ];
    }
}