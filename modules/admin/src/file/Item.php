<?php

namespace luya\admin\file;

use Yii;
use luya\helpers\Url;
use luya\helpers\FileHelper;
use luya\admin\helpers\I18n;
use luya\admin\storage\ItemAbstract;
use luya\web\LinkInterface;
use luya\web\LinkTrait;

/**
 * Storage File Item.
 *
 * @property string $caption The file caption
 * @property array $captionArray Contains the captions for all languages
 * @property integer $id The File id
 * @property integer $folderId The id of the folder the file is stored in.
 * @property \luya\admin\folder\Item $folder Get the folder item object.
 * @property string $name Get the original file name of the file.
 * @property string $systemFileName The new file name inside the storage folder.
 * @property string $mimeType The MIME type of the file while uploading.
 * @property string $extension The file extension name like jpg, gif, png etc.
 * @property integer $size Size of the file in Bytes.
 * @property string $sizeReadable The humand readable size.
 * @property integer $uploadTimestamp Unix timestamp when the file has been uploaded.
 * @property boolean $isImage Whether the file is of type image or not.
 * @property string $hashName The 8 chars long unique hash name of the file.
 * @property string $href Get the href value for the item based from $linkAbsolute
 * @property string $target Get the link target attribute value.
 * @property string $link Get the link path to the file.
 * @property string $linkAbsolute Get the absolute link path to the file.
 * @property string $source The source url to the file inside the storage folder with nice Urls.
 * @property string $sourceAbsolute The absolute source url to the file inside the storage folder with nice Urls.
 * @property string $serverSource The path to the file on the filesystem of the server.
 * @property boolean $isHidden Whether the file is marked as hidden or not.
 * @property boolean $isDeleted Return whether the file has been removed from the filesytem or not.
 * @property booelan $fileExists Whether the file resource exists in the storage folder or not.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Item extends ItemAbstract implements LinkInterface
{
    use LinkTrait;
    
    private $_imageMimeTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg', 'image/bmp', 'image/tiff'];
    
    private $_caption;
    
    /**
     * @inheritdoc
     */
    public function getHref()
    {
        return $this->linkAbsolute;
    }
    
    private $_target;
    
    /**
     * Setter method for Link target.
     *
     * @param string $target The target must be a valid link target attribute value.
     */
    public function setTarget($target)
    {
        $this->_target = $target;
    }
    
    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return empty($this->_target) ? '_blank' : $this->_target;
    }
    
    /**
     * Set caption for file item, override existings values
     *
     * @param string $text The caption text for this image
     * @since 1.0.0
     */
    public function setCaption($text)
    {
        $this->_caption = trim($text);
    }
    
    /**
     * Return the caption text for this file, if not defined the item array will be collected
     *
     * @return string The caption text for this image
     * @since 1.0.0
     */
    public function getCaption()
    {
        if ($this->_caption === null) {
            $this->_caption = I18n::findActive($this->getCaptionArray());
        }
    
        return $this->_caption;
    }
    
    /**
     * Get the array with all captions from the filemanager global "captions" definition for all provided languages
     *
     * @return array Get the array with all captions from the filemanager global "captions" definition for all provided languages
     */
    public function getCaptionArray()
    {
        return I18n::decode($this->getKey('caption'));
    }
    
    /**
     * Get the ID of the file (File-Id) and has nothing incommon with the image id.
     *
     * @return integer The id of the file from the database.
     */
    public function getId()
    {
        return (int) $this->getKey('id');
    }
    
    /**
     * Get the Id of the folder fhe file is stored in.
     *
     * @return integer The id of the folder where the file is located.
     */
    public function getFolderId()
    {
        return (int) $this->getKey('folder_id');
    }
    
    /**
     * Get the Folder Object where the file is stored in.
     *
     * @return \luya\admin\folder\Item The folder object
     */
    public function getFolder()
    {
        return Yii::$app->storage->getFolder($this->getFolderId());
    }
    
    /**
     * Get the original file name of the file.
     *
     * This is the file name the user has uploaded the file into the administration area. Including the file extensions
     *
     * @return string The original file name
     */
    public function getName()
    {
        return $this->getKey('name_original');
    }
    
    /**
     * Get the new defined storage file Name.
     *
     *  This is also known als *name_new_compound* from the admin_storage_file table. This is the original file name but
     *  without any bad letters or sign. Only a-z0-9 chars allowed.
     *
     * @return string The new file name inside the storage folder.
     */
    public function getSystemFileName()
    {
        return $this->getKey('name_new_compound');
    }
    
    /**
     * Get the MIME Type of the file.
     *
     * The mime type is defined while uploading the file and is not checked against any other services. For example
     * the MIME type could be:
     *
     * + image/png
     * + image/jpg
     * + image/gif
     * + application/pdf
     *
     * @return string The MIME type of the file while uploading.
     */
    public function getMimeType()
    {
        return $this->getKey('mime_type');
    }
    
    /**
     * Get the file extension.
     *
     * Contains the file extension of the file, this is used to concat the new file name with all its components.
     * Example extensions could be:
     *
     * + jpg
     * + gif
     * + pdf
     * + png
     *
     * Its also very commont to check the extensions against the mime type to make reading of files more secure.
     *
     * @return string The file extension name like jpg, gif, png etc.
     */
    public function getExtension()
    {
        return $this->getKey('extension');
    }
    
    /**
     * Get the size of the file in Bytes.
     *
     * @return string Size of the file in Bytes.
     */
    public function getSize()
    {
        return (int) $this->getKey('file_size');
    }
    
    /**
     * Get the size of a file in human readable size.
     *
     * For example sizes are partial splitet in readable forms:
     *
     * + 100B
     * + 100KB
     * + 10MB
     * + 1GB
     *
     * @return string The humand readable size.
     */
    public function getSizeReadable()
    {
        return FileHelper::humanReadableFilesize($this->getSize());
    }
    
    /**
     * The Unix Timestamp when the file has been uploaded to the Server.
     *
     * @return integer Unix timestamp when the file has been uploaded.
     */
    public function getUploadTimestamp()
    {
        return (int) $this->getKey('upload_timestamp');
    }
    
    /**
     * Whether the file is of type image or not.
     *
     * If the mime type of the files is equals to:
     *
     * + `image/gif`
     * + `image/jpeg`
     * + `image/jpg`
     * + `image/png`
     * + `image/bmp`
     * + `image/tiff`
     *
     * The file indicates to be an image and return value is true.
     *
     * @return boolean Whether the file is of type image or not.
     */
    public function getIsImage()
    {
        return in_array($this->getMimeType(), $this->_imageMimeTypes);
    }
    
    /**
     * The unique file hash name for the file itself.
     *
     * This identifier is also used to prevent external access on files when accessing them.
     *
     * @return string The 8 chars long unique hash name of the file.
     */
    public function getHashName()
    {
        return $this->getKey('hash_name');
    }
    
    /**
     * Get the md5 sum of the file calculated when creating.
     *
     * {{luya\helpers\FileHelper::md5sum}}
     *
     * @return string
     */
    public function getFileHash()
    {
        return $this->getKey('hash_file');
    }
    
    /**
     * Get the absolute source path to the file location on the webserver.
     *
     * This will return raw the path to the storage file inside the sotorage folder without readable urls.
     *
     * @param boolean $scheme Whether the source path should be absolute or not.
     * @return string The raw path to the file inside the storage folder.
     */
    public function getSource($scheme = false)
    {
        $httpPath = $scheme ? Yii::$app->storage->absoluteHttpPath : Yii::$app->storage->httpPath;
        
        return $httpPath . '/' . $this->getKey('name_new_compound');
    }
    
    /**
     * @deprecated Deprecated in 1.0.1
     *
     * @param boolean $scheme
     * @return string
     */
    public function getHttpSource($scheme = false)
    {
        trigger_error('deprecated, use getSource() instead of getHttpSource().', E_USER_DEPRECATED);
        
        return $this->getSource($scheme);
    }
    
    /**
     * Path to the source with sheme includes, means including server location.
     *
     * @return string The absolute source url to the file inside the storage folder with nice Urls.
     */
    public function getSourceAbsolute()
    {
        return $this->getSource(true);
    }
    
    /**
     * Get the link to a file.
     *
     * The is the most common method when implementing the file object. This method allows you to generate links to the request file. For
     * example you may want users to see the file (assuming its a PDF).
     *
     * ```php
     * echo '<a href="{Yii::$app->storage->getFile(123)->link}">Download PDF</a>'; // you could also us href instead in order to be more semantic.
     * ```
     *
     * The output of source is a url which is provided by a UrlRUle of the admin module and returns nice readable source links:
     *
     * ```
     * /file/<ID>/<HASH>/<ORIGINAL_NAME>.<EXTENSION>
     * ```
     *
     * which could look like this when fille up:
     *
     * ```
     * /public_html/en/file/123/e976e224/foobar.png
     * ```
     *
     * @return string The relative source url to the file inside the storage folder with nice Urls.
     */
    public function getLink($scheme = false)
    {
        return Url::toRoute(['/admin/file/download', 'id' => $this->getId(), 'hash' => $this->getHashName(), 'fileName' => $this->getName()], $scheme);
    }
    
    /**
     * Get the absolute link url but with the sheme includes, means including server location.
     *
     * This is equals to `getLink()` method but alos includes the sheme of the current running websites as prefix
     * and is not a relativ url its a static one.
     *
     * ```
     * https://luya.io/en/file/123/e976e224/foobar.png
     * ```
     *
     * @return string The absolute source url to the file inside the storage folder with nice Urls.
     */
    public function getLinkAbsolute()
    {
        return $this->getLink(true);
    }
    
    /**
     * Get the path to the source files internal, on the servers path.
     *
     * This is used when you want to to grab the file on server side for example to read the file
     * with `file_get_contents` and is the absolut path on the file system on the server.
     *
     * @return string The path to the file on the filesystem of the server.
     */
    public function getServerSource()
    {
        return Yii::$app->storage->serverPath . '/' . $this->getKey('name_new_compound');
    }
    
    /**
     * Return whether the file is hidden or not.
     *
     * Somefiles are uploaded by another process then the filemanager, for example user uploads in the
     * frontend can also be uploaded with the storage system but are hidden from the administration area
     * then the file is hidden but still available and usable.
     *
     * @since 1.0.0
     * @return boolean Whether the file is marked as hidden or not.
     */
    public function getIsHidden()
    {
        return (bool) $this->getKey('is_hidden');
    }
    
    /**
     * Return boolean value whether the file server source exsits on the server or not.
     *
     * @return boolean Whether the file still exists in the storage folder or not.
     */
    public function getFileExists()
    {
        return (bool) file_exists($this->getServerSource());
    }
    
    /**
     * Indicates wether a file is delete from the file system.
     *
     * When a file is deleted from the filesystem, for example by moving into the trash with the filemanager
     * in the administration area or by any other process who can delete files, the file will be removed from
     * the disk but will still exist in the database but is marked as *is_deleted*.
     *
     * @since 1.0.0
     * @return boolean Return whether the file has been removed from the filesytem or not.
     */
    public function getIsDeleted()
    {
        return (bool) $this->getKey('is_deleted');
    }
    
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id','folderId', 'name', 'systemFileName', 'source', 'link', 'href', 'serverSource', 'isImage', 'mimeType', 'extension', 'uploadTimestamp', 'size', 'sizeReadable', 'caption', 'captionArray'
        ];
    }
}
