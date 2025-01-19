About Migrator
--------------

Migrator is a [community](https://github.com/friends-of-sunlight-cms/) tool that was created to facilitate the migration from SunLight CMS 7.5.3 - 7.5.5 to 8.x. Keep in mind that Migrator may not be fully functional on all site installations. Unofficial changes and interventions in the system database, or changes using plugins, may cause the migration process to fail. **Backup the project, including the database, before performing the migration.**

Migration
---------

1.  ### Important steps before starting migration
    
    *   Rename the _pictures_ directory to _images_
    *   Remove all directories and files **except** _pictures_ and _upload_.
    *   Download the system from the official website [sunlight-cms.cz](https://sunlight-cms.cz/)
    *   Upload the **contents** of the _cms_ directory with the system files to the main directory on your web server (perhaps via FTP).
2.  ### Copying migrator files to the server
    
    Upload the _migration_ **directory** to the main directory on your web server (perhaps via FTP).
    
3.  ### Setting permissions
    
    On Unix web servers, you will probably need to set the uploaded files rights to at least 644 to use the backup, file manager functions, uploading avatars, adding images to galleries, generating thumbnails, etc.
    
4.  ### Database migration
    
    Open the _/migration path_ in a web browser (e.g. https://yourpages1/migration/). Then follow the displayed instructions. After a successful migration, you must delete the _migration_ and _install_ directories.
    

Conclusion
----------

For more information about the system, discussion, plugins and technical support, please visit the official website [sunlight-cms.cz](https://sunlight-cms.cz/).
