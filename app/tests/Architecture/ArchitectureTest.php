<?php

test('debugs are removed')
    ->expect(['dd', 'dump', 'var_dump'])
    ->not
    ->toBeUsed();

test('CommandInterface is implemented')
    ->expect('App\Command')
    ->toImplement(\App\Command\CommandInterface::class);

test('JsonSerializable is implemented')
    ->expect('App\Entity')
    ->toImplement(\JsonSerializable::class);

test('Controllers have Controller sufix')
    ->expect('App\Controller')
    ->toHaveSuffix('Controller');

test('application uses strict typing')
    ->expect('App')
    ->toUseStrictTypes();