<?php

namespace UnrealIRCd\Enums;

enum Ban: string {
    case BAN_GLINE = 'gline';
    case BAN_KLINE = 'kline';
    case BAN_ZLINE = 'zline';
    case BAN_GZLINE = 'gzline';
    case BAN_SHUN = 'shun';
}
