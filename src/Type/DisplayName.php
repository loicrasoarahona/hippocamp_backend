<?php

namespace App\Type;

use Symfony\Component\Serializer\Annotation\Groups;

class DisplayName
{
    #[Groups(['courseForum:item', 'courseForum:collection'])]
    public ?string $name;

    #[Groups(['courseForum:item', 'courseForum:collection'])]
    public ?string $surname;

    #[Groups(['courseForum:item', 'courseForum:collection'])]
    public ?string $email;

    #[Groups(['courseForum:item', 'courseForum:collection'])]
    public ?string $role;
}
