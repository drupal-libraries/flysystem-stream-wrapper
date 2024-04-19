<?php
/*
 * This file is part of the flysystem-stream-wrapper package.
 *
 * (c) 2021-2023 m2m server software gmbh <tech@m2m.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DrupalLibraries\FlysystemStreamWrapper\Flysystem\StreamCommand;

use DrupalLibraries\FlysystemStreamWrapper\Flysystem\FileData;

final class StreamEofCommand
{
    public static function run(FileData $current): bool
    {
        if (!is_resource($current->handle)) {
            return false;
        }

        return feof($current->handle);
    }
}
