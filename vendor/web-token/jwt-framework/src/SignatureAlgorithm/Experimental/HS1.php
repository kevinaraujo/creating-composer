<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2019 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Component\Signature\Algorithm;

final class HS1 extends HMAC
{
    public function name(): string
    {
        return 'HS1';
    }

    protected function getHashAlgorithm(): string
    {
        return 'sha1';
    }
}
