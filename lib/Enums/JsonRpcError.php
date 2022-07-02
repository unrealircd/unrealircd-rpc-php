<?php

namespace UnrealIRCd\Enums;

/*
 * This has basically been lifted from https://www.unrealircd.org/docs/JSON-RPC#JSON-RPC_Protocol
 *
 */
enum JsonRpcError: int
{
    // Official JSON-RPC error codes:
    /**< JSON parse error (fatal) */
    case JSON_RPC_ERROR_PARSE_ERROR = -32700;
    /**< Invalid JSON-RPC Request */
    case JSON_RPC_ERROR_INVALID_REQUEST = -32600;
    /**< Method not found */
    case JSON_RPC_ERROR_METHOD_NOT_FOUND = -32601;
    /**< Method parameters invalid */
    case JSON_RPC_ERROR_INVALID_PARAMS = -32602;
    /**< Internal server error */
    case JSON_RPC_ERROR_INTERNAL_ERROR = -32603;

    // UnrealIRCd JSON-RPC server specific error codes:
    /**< The api user does not have enough permissions to do this call */
    case JSON_RPC_ERROR_API_CALL_DENIED = -32000;

    // UnrealIRCd specific application error codes:
    /**< Target not found (no such nick / channel / ..) */
    case JSON_RPC_ERROR_NOT_FOUND = -1000;
    /**< Resource already exists by that name (eg on nickchange request, a gline, etc) */
    case JSON_RPC_ERROR_ALREADY_EXISTS = -1001;
    /**< Name is not permitted (eg: nick, channel, ..) */
    case JSON_RPC_ERROR_INVALID_NAME = -1002;
    /**< The user is not in the channel */
    case JSON_RPC_ERROR_USERNOTINCHANNEL = -1003;
    /**< Too many entries (eg: banlist, ..) */
    case JSON_RPC_ERROR_TOO_MANY_ENTRIES = -1004;
    /**< Permission denied for user (unrelated to api user permissions) */
    case JSON_RPC_ERROR_DENIED = -1005;

}
