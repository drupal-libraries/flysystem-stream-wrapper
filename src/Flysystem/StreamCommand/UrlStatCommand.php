<?php
/*
 * This file is part of the flysystem-stream-wrapper package.
 *
 * (c) 2021-2023 m2m server software gmbh <tech@m2m.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DrupalLibraries\FlysystemStreamWrapper\Flysystem\StreamCommand;

use League\Flysystem\FilesystemException;
use DrupalLibraries\FlysystemStreamWrapper\Flysystem\Exception\StatFailedException;
use DrupalLibraries\FlysystemStreamWrapper\Flysystem\FileData;

final class UrlStatCommand
{
    use ExceptionHandler;

    public const URL_STAT_COMMAND = 'url_stat';

    /** @return array<int|string,int|string>|false */
    public static function run(FileData $current, string $path, int $flags)
    {
        $current->setPath($path);

        try {
            return StreamStatCommand::getStat($current);
        } catch (FilesystemException $e) {
            if (($flags & STREAM_URL_STAT_QUIET) !== 0) {
                return false;
            }

            self::triggerError(StatFailedException::atLocation(self::URL_STAT_COMMAND, $path, $e));

            return false;
        }
    }
}
