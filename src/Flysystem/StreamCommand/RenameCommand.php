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
use DrupalLibraries\FlysystemStreamWrapper\Flysystem\Exception\DirectoryNotEmptyException;
use DrupalLibraries\FlysystemStreamWrapper\Flysystem\Exception\FileNotFoundException;
use DrupalLibraries\FlysystemStreamWrapper\Flysystem\Exception\IsDirectoryException;
use DrupalLibraries\FlysystemStreamWrapper\Flysystem\Exception\IsNotDirectoryException;
use DrupalLibraries\FlysystemStreamWrapper\Flysystem\FileData;

final class RenameCommand
{
    use ExceptionHandler;

    public const RENAME_COMMAND = 'rename';

    public static function run(FileData $current, string $path_from, string $path_to): bool
    {
        $current->setPath($path_from);

        $errorLocation = $path_from.','.$path_to;
        if (!file_exists($path_from)) {
            return self::triggerError(FileNotFoundException::atLocation(self::RENAME_COMMAND, $errorLocation));
        }

        if (file_exists($path_to)) {
            if (is_file($path_from) && is_dir($path_to)) {
                return self::triggerError(
                    IsDirectoryException::atLocation(self::RENAME_COMMAND, $errorLocation)
                );
            }
            if (is_dir($path_from) && is_file($path_to)) {
                return self::triggerError(
                    IsNotDirectoryException::atLocation(self::RENAME_COMMAND, $errorLocation)
                );
            }
        }

        try {
            $current->filesystem->move($current->file, FileData::getFile($path_to));

            return true;
        } catch (FilesystemException $e) {
            return self::triggerError(
                DirectoryNotEmptyException::atLocation(self::RENAME_COMMAND, $errorLocation, $e)
            );
        }
    }
}
