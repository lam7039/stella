<?php

namespace Stella\Core\Http\Response;

//TODO: i currently only use Response for Http, but I should also keep this class in mind for other types of responses like CLI, Event, WebSocket, etc.
interface Response
{
    public function body(): string;
}

