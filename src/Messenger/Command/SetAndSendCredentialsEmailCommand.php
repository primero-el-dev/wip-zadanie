<?php

namespace App\Messenger\Command;

use App\Messenger\Command\Command;
use App\Messenger\AsyncDoctrine;

/**
 * We set login and password short before sending email with credentials because we want
 * to avoid storing plain user's passwords (async commands are stored by doctrine)
 * nor we want to create login and not create password, so that user will be logged with empty password
 */
class SetAndSendCredentialsEmailCommand implements Command, AsyncDoctrine
{
	public function __construct(public readonly string $userId) {}
}