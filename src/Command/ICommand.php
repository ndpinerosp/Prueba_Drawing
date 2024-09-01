<?php

namespace App\Command;

interface ICommand
{
    public function execute(): void;
}