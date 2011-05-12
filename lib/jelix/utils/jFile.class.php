<?php
/**
* @package    jelix
* @subpackage utils
* @author Laurent Jouanneau
* @contributor Christophe Thiriot
* @contributor Bastien Jaillot
* @contributor Loic Mathaud
* @contributor Olivier Demah (#733)
* @contributor Cedric (fix bug ticket 56)
* @contributor Julien Issler
* @copyright   2005-2011 Laurent Jouanneau, 2006 Christophe Thiriot, 2006 Loic Mathaud, 2008 Bastien Jaillot, 2008 Olivier Demah, 2009-2010 Julien Issler
* @link        http://www.jelix.org
* @licence  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public Licence, see LICENCE file
*/


/**
 * A class helper to read or create files
 * @package    jelix
 * @subpackage utils
 */
class jFile {
    /**
    * Reads the content of a file.
    * @param string $filename the filename we're gonna read
    * @return string the content of the file. false if cannot read the file
    */
    public static function read ($filename){
        return @file_get_contents ($filename, false);
    }

    /**
    * Write a file to the disk.
    * This function is heavily based on the way smarty process its own files.
    * Is using a temporary file and then rename the file. We guess the file system will be smarter than us, avoiding a writing / reading
    *  while renaming the file.
    * This method comes from CopixFile class of Copix framework
    * @author     Gérald Croes
    * @copyright  2001-2005 CopixTeam
    * @link http://www.copix.org
    */
    public static function write ($file, $data){
        $_dirname = dirname($file);

        //asking to create the directory structure if needed.
        self::createDir ($_dirname);

        if(!@is_writable($_dirname)) {
            // cache_dir not writable, see if it exists
            if(!@is_dir($_dirname)) {
                throw new jException('jelix~errors.file.directory.notexists', array ($_dirname));
            }
            throw new jException('jelix~errors.file.directory.notwritable', array ($file, $_dirname));
        }

        // write to tmp file, then rename it to avoid
        // file locking race condition
        $_tmp_file = tempnam($_dirname, 'wrt');

        if (!($fd = @fopen($_tmp_file, 'wb'))) {
            $_tmp_file = $_dirname . '/' . uniqid('wrt');
            if (!($fd = @fopen($_tmp_file, 'wb'))) {
                throw new jException('jelix~errors.file.write.error', array ($file, $_tmp_file));
            }
        }

        fwrite($fd, $data);
        fclose($fd);

        // Delete the file if it allready exists (this is needed on Win,
        // because it cannot overwrite files with rename()
        if ($GLOBALS['gJConfig']->isWindows && file_exists($file)) {
            unlink($file);
        }
        rename($_tmp_file, $file);
        @chmod($file,  0664);

        return true;
    }

    /**
    * create a directory
    * It creates also all necessary parent directory
    * @param string $dir the path of the directory
    */
    public static function createDir ($dir){
        // recursive feature on mkdir() is broken with PHP 5.0.4 for Windows
        // so should do own recursion
        if (!file_exists($dir)) {
            self::createDir(dirname($dir));
            mkdir($dir, 0775);
        }
    }

    /**
     * Recursive function deleting a directory
     *
     * @param string $path The path of the directory to remove recursively
     * @param boolean $deleteParent If the path must be deleted too
     * @param array $except  filenames and suffix of filename, for files to NOT delete
     * @since 1.0b1
     * @author Loic Mathaud
     * @return boolean true if all the content has been removed
     */
    public static function removeDir($path, $deleteParent=true, $except=array()) {

        if($path == '' || $path == '/' || $path == DIRECTORY_SEPARATOR)
            throw new jException('jelix~errors.file.directory.cannot.remove.fs.root'); //see ticket #840

        if (!file_exists($path))
            return true;

        $allIsDeleted = true;

        $dir = new DirectoryIterator($path);
        foreach ($dir as $dirContent) {
            if (count($except)) {
                // test if the basename matches one of patterns
                $exception = false;
                foreach($except as $pattern) {
                    if ($pattern[0] == '*') { // for pattern like *.foo
                        if ($dirContent->getBasename() != $dirContent->getBasename(substr($pattern, 1))) {
                            $allIsDeleted = false;
                            $exception = true;
                            break;
                        }
                    }
                    else if ($pattern == $dirContent->getBasename()) {
                        $allIsDeleted = false;
                        $exception = true;
                        break;
                    }
                }
                if ($exception)
                    continue;
            }
        	// file deletion
            if ($dirContent->isFile() || $dirContent->isLink()) {
        		unlink($dirContent->getPathName());
        	} else {
        		// recursive directory deletion
                if (!$dirContent->isDot() && $dirContent->isDir()) {
                    $removed = self::removeDir($dirContent->getPathName(), true, $except);
                    if (!$removed)
                        $allIsDeleted = false;
        		}
        	}
        }
        unset($dir); // see bug #733
        unset($dirContent);

        // removes the parent directory
        if ($deleteParent && $allIsDeleted) {
            rmdir($path);
        }
        return $allIsDeleted;
    }

    /**
     * get the MIME Type of a file
     *
     * @param string $file The full path of the file
     * @return string the MIME type of the file
     * @since 1.1.6
     */
    public static function getMimeType($file){
        if (function_exists('finfo_open')) { 
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $file);
            finfo_close($finfo);
            return $type;
        }
        else
            return mime_content_type($file);
    }
}