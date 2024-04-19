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

final class DirReaddirCommand
{
    /**
     * @return string|false
     */
    public static function run(FileData $current)
    {
        if (!$current->dirListing->valid()) {
            return false;
        }

        $item = $current->dirListing->current();

        $current->dirListing->next();

        return basename($item->path());
    }
}
