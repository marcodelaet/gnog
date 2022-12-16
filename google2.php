<!DOCTYPE html>
<html>
  <head>
    <title>Drive API Quickstart</title>
    <meta charset="utf-8" />
  </head>
  <body>

    <pre id="content" style="white-space: pre-wrap;"></pre>

    <script type="text/javascript">
      /* exported gapiLoaded */
      /* exported gisLoaded */
      /* exported handleAuthClick */
      /* exported handleSignoutClick */

      // TODO(developer): Set to client ID and API key from the Developer Console
      const CLIENT_ID = '1050852633338-g6qjebdmi5d8vlkgqn4ksnilluscrek7.apps.googleusercontent.com';
      const API_KEY = 'AIzaSyAAd-Mt3a5aktJwbPXlqGq03zl2B0gWfuI';

      // Discovery doc URL for APIs used by the quickstart
      const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/drive/v3/rest';

      // Authorization scopes required by the API; multiple scopes can be
      // included, separated by spaces.
      const SCOPES = 'https://www.googleapis.com/auth/drive.metadata.readonly';

      let tokenClient;
      let gapiInited = false;
      let gisInited = false;
      function getFileList(folderId) {
        var folderlist = (function(folder, folderSt, results) {
        var ar = [];
        var folders = folder.getFolders();
        while (folders.hasNext()) ar.push(folders.next());
        folderSt += folder.getId() + "#_aabbccddee_#";
        var array_folderSt = folderSt.split("#_aabbccddee_#");
        array_folderSt.pop()
        results.push(array_folderSt);
        ar.length == 0 && (folderSt = "");
        for (var i in ar) arguments.callee(ar[i], folderSt, results);
        return results;
        })(DriveApp.getFolderById(folderId), "", []);

        var localTimeZone = Session.getScriptTimeZone();
        var filelist = [];
        var temp = {};
        for (var i in folderlist) {
            var folderid = folderlist[i][folderlist[i].length - 1];
            var folder = DriveApp.getFolderById(folderid);
            var files = folder.getFiles();
            while (files.hasNext()) {
                var file = files.next();
                temp = {
                    folder_tree: function(folderlist, i) {
                        if (i > 0) {
                            return "/" + [DriveApp.getFolderById(folderlist[i][j]).getName() for (j in folderlist[i])
                                if (j > 0)].join("/") + "/";
                        } else {
                            return "/";
                        }
                    }(folderlist, i),
                    file_id: file.getId(),
                    file_name: file.getName(),
                    file_mimetype: file.getMimeType(),
                    file_created: Utilities.formatDate(file.getDateCreated(), localTimeZone, "yyyy/MM/dd HH:mm:ss"),
                    file_updated: Utilities.formatDate(file.getLastUpdated(), localTimeZone, "yyyy/MM/dd HH:mm:ss"),
                };
                filelist.push(temp);
                temp = {}
            }
        }
        var sortedlist = filelist.sort(function(e1, e2) {
            return (e1.folder_tree > e2.folder_tree ? 1 : -1) });
        return sortedlist;
    }
    </script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
  </body>
</html>